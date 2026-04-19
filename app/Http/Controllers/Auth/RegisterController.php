<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'nama'      => 'required',
            'username'  => 'required|unique:users',
            'password'  => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'email'     => $request->email,
            'nama'      => $request->nama,
            'username'  => $request->username,
            'password'  => bcrypt($request->password),

            // default system
            'kode_jabatan' => 'GK',
            'kode_golongan' => 'IA',
            'kode_status_pegawai' => 'PPPK',
            'nip' => rand(10000000, 99999999),
            'nomor_hp' => '081234567890',
            'alamat' => 'Pekanbaru',
            'role' => 'guru',
        ]);

        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }
}
