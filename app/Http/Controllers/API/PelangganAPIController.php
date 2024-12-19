<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganAPIController extends Controller
{
    public function dashboard()
    {
        // Implement dashboard logic for pelanggan
        return response()->json(['message' => 'Pelanggan dashboard data']);
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return response()->json($pelanggan);
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggan,email,' . $id,
            // Add other necessary fields
        ]);

        $pelanggan->update($validatedData);
        return response()->json($pelanggan);
    }

    public function list()
    {
        $pelanggan = Pelanggan::all();
        return response()->json($pelanggan);
    }
}
