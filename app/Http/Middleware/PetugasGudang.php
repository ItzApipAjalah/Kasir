<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasGudang
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('petugas_gudang')->check()) {
            return $next($request);
        }

        return redirect('/login');
    }
}
