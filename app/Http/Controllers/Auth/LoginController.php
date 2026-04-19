<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\Concerns\Has;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // $password = Hash::make($request->password);
        //set validation
        $validator = Validator::make($request->all(), [
            'username'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //get credentials from request
        $credentials = $request->only('username', 'password');

        //if auth failed
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'username atau Password Anda salah'
            ], 401);
        }

        //get user by id_user
        $id_user = User::where('id_user', $request->id_user)->first();

        // Generate token
        $token = $request->user()->createToken('auth_token')->plainTextToken;

        //if auth success
        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil',
            'token' => $token,
            'token_type' => 'Bearer',
            'id_user' => Auth::user()->id_user,
            'user' => Auth::user()
        ]);
    }
}
