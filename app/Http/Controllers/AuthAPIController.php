<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Pelanggan;

class AuthAPIController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::guard('pelanggan')->attempt($credentials)) {
        $user = Auth::guard('pelanggan')->user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 200);
    }

    return response()->json([
        'message' => 'Email or password is incorrect.',
    ], 401);
}


    public function logout(Request $request)
    {
        $user = Auth::guard('pelanggan')->user();

        if ($user) {
            $user->tokens()->delete();
            Auth::guard('pelanggan')->logout();

            return response()->json([
                'message' => 'Successfully logged out',
            ], 200);
        }

        return response()->json([
            'message' => 'No user is logged in.',
        ], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggans',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $pelanggan = new Pelanggan;
        $pelanggan->name = $request->name;
        $pelanggan->email = $request->email;
        $pelanggan->password = Hash::make($request->password);
        $pelanggan->save();

        return response()->json([
            'message' => 'Registration successful. Please log in.',
        ], 201);
    }

    public function user(Request $request)
    {
        return response()->json($request->user(), 200);
    }
}
