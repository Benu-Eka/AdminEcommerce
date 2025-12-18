<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Asumsi view login ada di resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba proses login
        if (Auth::attempt($credentials, $request->remember)) {
            
            $request->session()->regenerate();

            // Cek role setelah login berhasil
            if (Auth::user()->isAdmin()) {
                // Redirect ke dashboard admin jika role = Admin
                return redirect()->intended(route('admin.dashboard'));
            }

            // Jika role bukan Admin, log out atau arahkan ke halaman non-admin
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun Anda tidak memiliki hak akses Admin.',
            ])->onlyInput('email');

        }

        // Login gagal
        return back()->withErrors([
            'email' => 'Kombinasi email dan password tidak valid.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}