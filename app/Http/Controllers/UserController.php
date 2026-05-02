<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
    {

        try {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nip' => 'required',
            'username' => 'required|unique:users,username',
            'nomor_hp' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'role' => 'required|in:guru,operator,kepala_sekolah'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json([
            "success" => true,
            "data" => $user
        ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error-code' => $e->getCode(),
                'error-message' => $e->getMessage(),
                'error' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $data = $request->all();

            // kalau password dikirim, hash dulu
            if ($request->has('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diupdate',
                'data' => $user
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'message' => 'User berhasil dihapus'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User tidak ditemukan'
            ], 404);
        }
    }
}
