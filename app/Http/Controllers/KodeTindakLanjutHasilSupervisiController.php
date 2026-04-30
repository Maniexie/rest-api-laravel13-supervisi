<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KodeTindakLanjutHasilSupervisi;

class KodeTindakLanjutHasilSupervisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
             return response()->json([
        'success' => true,
        'data' => KodeTindakLanjutHasilSupervisi::all()
    ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Data tidak ditemukan'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $user = KodeTindakLanjutHasilSupervisi::create($data);

            return response()->json([
                "success" => true,
                "message" => "Kode Tindak Lanjut Hasil Supervisi berhasil ditambahkan",
                "data" => $user,
                201
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Kode Tindak Lanjut Hasil Supervisi tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($kode)
    {
        try {
            $data = KodeTindakLanjutHasilSupervisi::where('kode_tindak_lanjut', $kode)->first();

            if (!$data) {
                return response()->json([
                    'error' => 'Data tidak ditemukan'
                ], 404);
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $data = $request->all();
            $user = KodeTindakLanjutHasilSupervisi::findOrFail($id);
            $user->update($data);

            return response()->json([
                "success" => true,
                "message" => "Kode Tindak Lanjut Hasil Supervisi berhasil diupdate",
                "data" => $user,
                200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Kode Tindak Lanjut Hasil Supervisi tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = KodeTindakLanjutHasilSupervisi::findOrFail($id);
            $user->delete();

            return response()->json([
                "success" => true,
                "message" => "Kode Tindak Lanjut Hasil Supervisi berhasil dihapus",
                "data" => $user,
                200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Kode Tindak Lanjut Hasil Supervisi tidak ditemukan'
            ], 404);
        }
    }
}
