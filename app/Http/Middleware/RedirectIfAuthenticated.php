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
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                switch ($guard) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'petugas':
                        return redirect()->route('petugas.dashboard');
                    case 'petugas_gudang':
                        return redirect()->route('petugas_gudang.dashboard');
                    case 'pelanggan':
                        return redirect()->route('pelanggan.dashboard');
                }
            }
        }

        return $next($request);
    }
}
