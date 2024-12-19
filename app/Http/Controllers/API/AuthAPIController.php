<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pelanggan;

class AuthAPIController extends Controller
{
    public function showLoginForm()
    {
        return response()->json(['message' => 'Please use POST request to login']);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $abilities = $this->getAbilities($user);
            $token = $user->createToken('auth_token', $abilities)->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    private function getAbilities($user)
    {
        if ($user instanceof Admin) {
            return ['admin'];
        } elseif ($user instanceof Petugas) {
            return ['petugas'];
        } elseif ($user instanceof PetugasGudang) {
            return ['petugas_gudang'];
        } elseif ($user instanceof Pelanggan) {
            return ['pelanggan'];
        }
        return [];
    }

    public function showRegisterForm()
    {
        return response()->json(['message' => 'Please use POST request to register']);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggan',
            'password' => 'required|string|min:8',
        ]);

        $pelanggan = Pelanggan::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        $token = $pelanggan->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $pelanggan,
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
