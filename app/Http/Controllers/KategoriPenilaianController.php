<?php

namespace App\Http\Controllers;

use App\Models\KategoriPenilaian;
use Illuminate\Http\Request;

class KategoriPenilaianController extends Controller
{
    public function index()
    {
        try {
            return response()->json(KategoriPenilaian::all());
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

    public function store(Request $request)
    {
        try {
            $data = request()->all();
            $user = KategoriPenilaian::create($data);

            return response()->json([
                "success" => true,
                "message" => "Kategori Penilaian berhasil ditambahkan",
                "data" => $user,
                201
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Kategori Penilaian tidak ditemukan'
            ], 404);
        }
    }

    public function show($id)
    {
        try {
            return response()->json(KategoriPenilaian::findOrFail($id));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Kategori Penilaian tidak ditemukan'
            ], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = $request->all();
            $user = KategoriPenilaian::findOrFail($id);
            $user->update($data);

            return response()->json([
                "success" => true,
                "message" => "Kategori Penilaian berhasil diupdate",
                "data" => $user,
                200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Kategori Penilaian tidak ditemukan'
            ], 404);
        }
    }

    public function destroy(string $id)
    {
        try {
            $user = KategoriPenilaian::findOrFail($id);
            $user->delete();

            return response()->json([
                "success" => true,
                "message" => "Kategori Penilaian berhasil dihapus",
                "data" => $user,
                200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Kategori Penilaian tidak ditemukan'
            ], 404);
        }
    }
}
