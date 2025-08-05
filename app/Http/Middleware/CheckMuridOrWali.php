<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckMuridOrWali
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Cek apakah user terautentikasi sebagai murid atau wali
        if (Auth::guard('murid')->check() || Auth::guard('wali')->check()) {
            return $next($request);
        }

        // Jika tidak, arahkan ke halaman unauthorized atau login
        return redirect()->route('login')->withErrors(['unauthorized' => 'Akses ditolak.']);
    }
}
