<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // Cek apakah pengguna sudah terautentikasi
        if (Auth::guard($guard)->check()) {
            // Redirect ke dashboard admin jika pengguna admin
            if ($guard == 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // Redirect ke dashboard petugas jika pengguna petugas
            if ($guard == 'petugas') {
                return redirect()->route('petugas.dashboard');
            }

            // Redirect ke dashboard pelanggan jika pengguna pelanggan
            if ($guard == 'pelanggan') {
                return redirect()->route('pelanggan.dashboard');
            }

            // Redirect ke dashboard petugas_gudang jika pengguna petugas_gudang
            if ($guard == 'petugas_gudang') {
                return redirect()->route('petugas_gudang.dashboard');
            }
        }

        return $next($request);
    }
}
