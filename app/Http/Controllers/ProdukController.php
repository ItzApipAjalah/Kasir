<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::all();

        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        return view('admin.produk.create');
    }

    public function showBarcode($id)
    {
        $produk = Produk::findOrFail($id);
        $barcode = DNS1D::getBarcodePNG($produk->produk_id, 'C128');
        return view('produk.showBarcode', compact('produk', 'barcode'));
    }

    public function downloadBarcode($id)
    {
        $produk = Produk::findOrFail($id);
        $d = new DNS1D();
        $d->setStorPath(storage_path('framework/barcode/'));
        $barcodeData = $d->getBarcodePNG($produk->produk_id, 'C128');
        $barcodeBase64 = base64_decode($barcodeData);

        $filename = 'barcode-' . $produk->produk_id . '.png';
        $path = storage_path('app/public/' . $filename);

        // Save the barcode as a PNG file
        file_put_contents($path, $barcodeBase64);

        // Download the file
        return response()->download($path)->deleteFileAfterSend(true);
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

    return redirect()->route('produk.index')->with('success', 'Produk created successfully.');
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
        return view('admin.produk.edit', compact('produk'));
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

        return redirect()->route('produk.index')->with('success', 'Produk updated successfully.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk deleted successfully.');
    }
}
