<?php

namespace App\Http\Controllers;

use App\Models\HasilSupervisi;
use Illuminate\Http\Request;

class HasilSupervisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => HasilSupervisi::all()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan server | error di HasilSUpervisiController index',
                'error-code' => $th->getCode(),
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => HasilSupervisi::findOrFail($id)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan server | error di HasilSUpervisiController show',
                'error-code' => $th->getCode(),
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function detailByJadwalGuru($idJadwal, $idGuru)
{
    try {
        $data = HasilSupervisi::where('id_jadwal_supervisi', $idJadwal)
            ->where('id_guru', $idGuru)
            ->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);

    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => $th->getMessage()
        ], 500);
    }
}
}
