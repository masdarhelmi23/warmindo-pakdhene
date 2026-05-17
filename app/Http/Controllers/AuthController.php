<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->forget('url.intended');
            $request->session()->regenerate();
            
            $user = Auth::user();

            // Tentukan rute redirect berdasarkan data asli kata 'kasir' di database
            if ($user->role === 'owner') {
                return response()->json([
                    'success' => true,
                    'role' => 'owner',
                    'name' => $user->name,
                    'redirect_url' => url('/owner/dashboard')
                ]);
            }

            if ($user->role === 'kasir') {
                return response()->json([
                    'success' => true,
                    'role' => 'kasir',
                    'name' => $user->name,
                    'redirect_url' => url('/dashboard')
                ]);
            }

            // Jika role tidak dikenali
            return response()->json([
                'success' => true,
                'role' => 'unknown',
                'name' => $user->name,
                'redirect_url' => url('/')
            ]);
        }

        // Jika gagal login, kembalikan response error JSON
        return response()->json([
            'success' => false,
            'message' => 'Email atau Password yang Anda masukkan salah!'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}