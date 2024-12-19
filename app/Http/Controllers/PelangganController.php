<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Hanya izinkan pelanggan itu sendiri atau admin untuk mengedit
        if (Auth::guard('pelanggan')->id() == $id || Auth::guard('admin')->check()) {
            return view('pelanggan.edit', compact('pelanggan'));
        }

        return redirect()->route('home')->withErrors('You do not have permission to edit this data.');
    }

    // Update data pelanggan
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Hanya izinkan pelanggan itu sendiri atau admin untuk mengupdate
        if (Auth::guard('pelanggan')->id() == $id || Auth::guard('admin')->check()) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:pelanggans,email,'.$pelanggan->id,
                'alamat' => 'nullable|string|max:255',
                'nomor_telepon' => 'nullable|string|max:15',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $pelanggan->name = $request->name;
            $pelanggan->email = $request->email;
            $pelanggan->alamat = $request->alamat;
            $pelanggan->nomor_telepon = $request->nomor_telepon;

            if ($request->filled('password')) {
                $pelanggan->password = Hash::make($request->password);
            }

            $pelanggan->save();

            return redirect()->route('pelanggan.show', $pelanggan->id)->with('success', 'Data updated successfully.');
        }

        return redirect()->route('home')->withErrors('You do not have permission to update this data.');
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        return view('pelanggan.profile', compact('pelanggan'));
    }
}
