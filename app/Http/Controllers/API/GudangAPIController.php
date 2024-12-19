<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class GudangAPIController extends Controller
{
    public function dashboard()
    {
        // Implement dashboard logic for petugas gudang
        return response()->json(['message' => 'Petugas Gudang dashboard data']);
    }

    public function index()
    {
        $produk = Produk::all();
        return response()->json($produk);
    }

    public function create()
    {
        return response()->json(['message' => 'Use POST request to create a new produk']);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            // Add other necessary fields
        ]);

        $produk = Produk::create($validatedData);
        return response()->json($produk, 201);
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json($produk);
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return response()->json($produk);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            // Add other necessary fields
        ]);

        $produk->update($validatedData);
        return response()->json($produk);
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return response()->json(null, 204);
    }
}
