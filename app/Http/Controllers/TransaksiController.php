<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'petugas_id' => 'required|exists:petugas,id',
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'produk' => 'required|array',
            'produk.*.id' => 'required|exists:produk,id',
            'produk.*.quantity' => 'required|integer|min:1',
        ]);

        // Calculate total price
        $totalHarga = 0;
        foreach ($request->produk as $item) {
            $produk = Produk::find($item['id']);
            $totalHarga += $produk->harga * $item['quantity'];
        }

        // Create a new transaction
        $transaksi = Transaksi::create([
            'petugas_id' => $request->petugas_id,
            'pelanggan_id' => $request->pelanggan_id,
            'total_harga' => $totalHarga,
        ]);

        // Save transaction details
        foreach ($request->produk as $item) {
            $produk = Produk::find($item['id']);
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk' => json_encode($produk),
                'quantity' => $item['quantity'],
                'subtotal' => $produk->harga * $item['quantity'],
            ]);
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi created successfully.');
    }
}
