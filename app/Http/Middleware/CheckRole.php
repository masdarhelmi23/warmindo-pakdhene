<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Jika belum login, tendang ke gerbang login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Jika role user cocok dengan array parameter rute, berikan akses masuk murni
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Jika melanggar perimeter akses, bunuh request dengan 403 (Anti-Looping)
        abort(403, 'Akses ditolak! Anda tidak memiliki wewenang untuk membuka halaman ini.');
    }
}