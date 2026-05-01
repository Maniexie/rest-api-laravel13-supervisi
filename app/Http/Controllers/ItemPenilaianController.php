<?php

namespace App\Http\Controllers;

use App\Models\ItemPenilaian;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemPenilaianController extends Controller
{
    public function index()
    {
        try {
            return response()->json(ItemPenilaian::all());
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan server']);
        }
    }

    public function show($id)
    {
        try {
            return response()->json(ItemPenilaian::findOrFail($id));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan server']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Item Penilaian tidak ditemukan']);
        }
    }

    public function store(Request $request)
    {
        try {

            $data = ItemPenilaian::create([
                'kode_kategori_penilaian' => $request->kode_kategori_penilaian,
                'pernyataan' => $request->pernyataan,
                'versi' => $request->versi,
                'nilai_aiken' => 0,
                'status' => 'tidak_valid',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item Penilaian berhasil disimpan',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan server']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $item = ItemPenilaian::findOrFail($id);
            $item->update([
                'kode_kategori_penilaian' => $request->kode_kategori_penilaian,
                'pernyataan' => $request->pernyataan,
                'versi' => $request->versi,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item Penilaian berhasil diperbarui',
                'data' => $item,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $item = ItemPenilaian::findOrFail($id);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil dihapus',
        ]);
    }

    public function getVersiItem()
    {
        try {
            $data = ItemPenilaian::select('versi')
                ->distinct()
                ->orderBy('versi', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function groupByVersi()
    {
        try {
            $data = ItemPenilaian::whereNotNull('versi')
                ->get()
                ->groupBy('versi')
                ->map(function ($items, $versi) {
                    return [
                        'versi' => (int) $versi,
                        'total_item' => $items->count(),
                        'items' => $items->values()->toArray(),
                    ];
                })
                ->values();

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    public function getDetailKuesionerByVersi($versi)
    {
        try {
            // $user = User::where('role', 'validator')->first();
            $data = ItemPenilaian::where('versi', $versi)->get();

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

public function toggleDigunakan($id)
{
    $item = DB::table('item_penilaian')
        ->where('id_item_penilaian', $id)
        ->first();

    if (!$item) {
        return response()->json([
            'success' => false,
            'message' => 'Item tidak ditemukan'
        ], 404);
    }

    // 🔥 HANYA ITEM VALID YANG BOLEH DIGUNAKAN
    if ($item->status !== 'valid') {
        return response()->json([
            'success' => false,
            'message' => 'Item belum valid'
        ], 400);
    }

    $newValue = !$item->isDigunakan;

    DB::table('item_penilaian')
        ->where('id_item_penilaian', $id)
        ->update([
            'isDigunakan' => $newValue
        ]);

    return response()->json([
        'success' => true,
        'isDigunakan' => $newValue,
        'message' => $newValue ? 'Item digunakan' : 'Item tidak digunakan'
    ]);
}


// public function getItemDigunakan()
// {
//     $query = DB::table('item_penilaian')
//         ->where('status', 'valid')
//         ->where('isDigunakan', true);

//     return response()->json([
//         'success' => true,
//         'total' => $query->count(), // ✅ aman
//         'data' => $query->get()     // ✅ ambil data
//     ]);
// }

public function getItemDigunakan()
{
    $data = DB::table('item_penilaian')
        ->join('k_penilaian', 'item_penilaian.kode_kategori_penilaian', '=', 'k_penilaian.kode_kategori_penilaian')
        ->select(
            'item_penilaian.*',
            'k_penilaian.nama_kategori_penilaian'
        )
        ->where('item_penilaian.isDigunakan', 1)
        ->get();

    return response()->json([
        'data' => $data
    ]);
}
}
