<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\Transaction;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function dashboard_admin ()
    {
        return view('admin.dashboard');
    }

    public function dashboard_pelanggan()
    {
        // Retrieve the currently authenticated pelanggan
        $pelanggan = Auth::guard('pelanggan')->user();

        // Fetch the transaction history along with the details for the authenticated pelanggan
        $transactions = Transaction::where('customer_id', $pelanggan->id)
                                   ->with('transactionDetails')
                                   ->get();

        return view('pelanggan.dashboard', compact('pelanggan', 'transactions'));
    }


    public function dashboard_petugas () {
        $produk = Produk::all();
        $pelanggan = Pelanggan::all();
        $petugasId = Auth::id(); // Get the authenticated user's ID
        $petugas = Auth::guard('petugas')->user();


        return view('petugas.dashboard', compact('produk', 'pelanggan', 'petugasId', 'petugas'));
    }

    public function history_petugas () {
        $produk = Produk::all();
        $pelanggan = Pelanggan::all();
        $petugas = Auth::guard('petugas')->user();
        $transactions = Transaction::where('staff_id', $petugas->id)
        ->with('transactionDetails')
        ->get();
        return view('petugas.history' , compact('produk', 'pelanggan', 'petugas' , 'transactions'));
    }

    public function getPetugasId() {
        return response()->json(Auth::guard('petugas')->user()->id);
    }
    public function dashboard_gudang () {
        $produks = Produk::all();
        $pelanggan = Pelanggan::all();
        return view('petugas_gudang.dashboard', compact('produks' , 'pelanggan'));
    }

    public function list()
    {
        // Retrieve all customers from the database
        $pelanggan = Pelanggan::all();

        // Return the customers as JSON
        return response()->json($pelanggan);
    }

    public function ListById($id)
    {
        $pelanggan = Pelanggan::find($id);
        return response()->json($pelanggan);
    }
}
