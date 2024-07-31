<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Produk;

use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function dashboard_admin ()
    {
        return view('admin.dashboard');
    }

    public function dashboard_pelanggan ()
    {
        return view('pelanggan.dashboard');
    }

    public function dashboard_petugas () {
        $produk = Produk::all();
        return view('petugas.dashboard', compact('produk'));
    }

    public function dashboard_gudang () {
        return view('petugas_gudang.dashboard');
    }
}
