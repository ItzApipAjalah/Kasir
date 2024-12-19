<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PetugasGudang;
use Illuminate\Support\Facades\Storage;
use App\Models\Produk;

class GudangController extends Controller
{
    public function create()
    {
        return view('petugas_gudang.produk.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'namaproduk' => 'required|string|max:255',
        'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'harga' => 'required|numeric',
        'stok' => 'required|integer',
    ]);

    // Generate a unique 5-digit ID
    $uniqueID = $this->generateUniqueID();

    if ($request->hasFile('thumbnail')) {
        $thumbnailPath = $request->file('thumbnail')->store('produk_thumbnails', 'public');
    }

    Produk::create([
        'produk_id' => $uniqueID,
        'namaproduk' => $request->namaproduk,
        'thumbnail' => $thumbnailPath,
        'harga' => $request->harga,
        'stok' => $request->stok,
    ]);

    return redirect()->route('petugas.produk.index')->with('success', 'Produk created successfully.');
}


    private function generateUniqueID()
    {
        do {
            $id = rand(10000, 99999);
        } while (Produk::where('produk_id', $id)->exists());

        return $id;
    }


    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('petugas_gudang.produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaproduk' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        $produk = Produk::findOrFail($id);

        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($produk->thumbnail) {
                Storage::disk('public')->delete($produk->thumbnail);
            }

            // Simpan thumbnail baru
            $thumbnailPath = $request->file('thumbnail')->store('produk_thumbnails', 'public');
            $produk->thumbnail = $thumbnailPath;
        }

        $produk->namaproduk = $request->namaproduk;
        $produk->harga = $request->harga;
        $produk->stok = $request->stok;
        $produk->save();

        return redirect()->route('petugas.produk.index')->with('success', 'Produk updated successfully.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('petugas.produk.index')->with('success', 'Produk deleted successfully.');
    }
}
