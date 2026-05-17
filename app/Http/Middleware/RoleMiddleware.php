<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika belum login, lempar ke login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek apakah role user ada dalam daftar role yang diizinkan
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, lempar ke dashboard atau kasih error 403
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}