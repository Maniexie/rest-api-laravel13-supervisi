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
                'versi' => 1,
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

    //
    // public function store(Request $request)
    // {
    //     DB::table('jawaban_validator')->insert([
    //         'id_item_penilaian' => $request->id_item,
    //         'id_validator' => $request->id_validator,
    //         'jawaban' => $request->jawaban,
    //         'versi' => 1
    //     ]);

    //     return response()->json(['message' => 'Berhasil disimpan']);
    // }

    public function storeBulk(Request $request)
    {
        try {

            $data = [];

            foreach ($request->jawaban as $item) {
                $data[] = [
                    'id_item_penilaian' => $item['id_item'],
                    'id_validator' => $request->id_validator,
                    'jawaban' => $item['nilai'],
                    'versi' => 1,
                ];
            }

            DB::table('jawaban_validator')->insert($data);

            return response()->json([
                'message' => 'Semua jawaban berhasil disimpan',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server',
            ], 500);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Item Penilaian tidak ditemukan',
            ], 404);
        }
    }
}
