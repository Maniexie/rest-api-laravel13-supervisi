<?php

namespace App\Http\Controllers;

use App\Models\KodeStatusPegawai;
use Illuminate\Http\Request;

class KodeStatusPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            return response()->json([
                'success' => true,
                'data' => KodeStatusPegawai::all()
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
        try{
            $data = $request->all();
            $user = KodeStatusPegawai::create($data);

            return response()->json([
                'success' => true,
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            return response()->json([
                'success' => true,
                'data' => KodeStatusPegawai::findOrFail($id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
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
            $user = KodeStatusPegawai::findOrFail($id);
            $user->update($data);

            return response()->json([
                'success' => true,
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = KodeStatusPegawai::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                'data' => $user
            ])
            ->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        }
    }
}
