<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah'
            ], 401);
        }

        $token = $user->createToken('token-api')->plainTextToken;



       return response()->json([
        'success' => true,
        'message' => 'Login berhasil',
        'token' => $token,
        'user' => [
            'id_user' => $user->id_user,
            'nama' => $user->nama,
            'username' => $user->username,
            'role' => $user->role, // 🔥 penting
            'isValidator' => (bool) $user->isValidator
        ]
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}
?>

