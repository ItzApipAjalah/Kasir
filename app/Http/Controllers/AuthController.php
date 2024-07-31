<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Petugas;
use App\Models\PetugasGudang;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to authenticate as admin
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        // Attempt to authenticate as petugas
        if (Auth::guard('petugas')->attempt($credentials)) {
            return redirect()->route('petugas.dashboard');
        }

        // Attempt to authenticate as pelanggan
        if (Auth::guard('pelanggan')->attempt($credentials)) {
            return redirect()->route('pelanggan.dashboard');
        }

        // Attempt to authenticate as petugas_gudang
        if (Auth::guard('petugas_gudang')->attempt($credentials)) {
            return redirect()->route('petugas_gudang.dashboard');
        }

        // If authentication fails
        return back()->withErrors([
            'email' => 'Email or password is incorrect.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('petugas')->check()) {
            Auth::guard('petugas')->logout();
        } elseif (Auth::guard('pelanggan')->check()) {
            Auth::guard('pelanggan')->logout();
        } elseif (Auth::guard('petugas_gudang')->check()) {
            Auth::guard('petugas_gudang')->logout();
        }

        return redirect('/login');
    }


    public function showRegisterForm()
    {
        return view('auth.register');
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

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }
}
