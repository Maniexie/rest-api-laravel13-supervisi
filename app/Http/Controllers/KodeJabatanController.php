<?php

namespace App\Http\Controllers;

use App\Models\KodeJabatan;
use Illuminate\Http\Request;

class KodeJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => KodeJabatan::all()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $user = KodeJabatan::create($data);

            return response()->json([
                'success' => true,
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error-code' => $e->getCode(),
                'error-message' => $e->getMessage(),
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
                'data' => KodeJabatan::findOrFail($id)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error-code' => $e->getCode(),
                'error-message' => $e->getMessage(),
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
            $user = KodeJabatan::findOrFail($id);
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
            $user = KodeJabatan::findOrFail($id);
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
