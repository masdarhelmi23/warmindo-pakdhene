<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfLoggedIn
{
    public function handle(Request $request, Closure $next)
    {
        // JURUS SAKTI: Jika user SUDAH login, jangan bolehin lihat halaman login lagi!
        if (Auth::check()) {
            $user = Auth::user();

            // Tendang langsung ke dashboard sesuai role asli mereka
            if ($user->role === 'owner') {
                return redirect()->route('owner.dashboard');
            }

            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            }

            return redirect('/');
        }

        return $next($request);
    }
}