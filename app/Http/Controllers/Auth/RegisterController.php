<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Tambahkan validasi username karena di DB bersifat NOT NULL & UNIQUE
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            // 2. Sesuaikan format user_id agar mirip dengan data di SQL (USR-XXXXXX)
            $newUserId = 'USR-' . strtoupper(Str::random(6));

            $user = User::create([
                'user_id' => $newUserId,
                'nama_lengkap' => $request->nama_lengkap,
                'username' => $request->username, // Wajib diisi sesuai DB
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'Admin', // Gunakan 'Admin' (Capital Case) sesuai ENUM di SQL
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');

        } catch (\Exception $e) {
            \Log::error('Admin registration failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['register' => 'Gagal membuat akun: ' . $e->getMessage()])->withInput();
        }
    }
}