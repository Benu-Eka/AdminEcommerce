<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah pengguna sudah login
        // 2. Cek apakah role pengguna adalah 'Admin'
        // Kita menggunakan helper isAdmin() yang sudah dibuat di model User
        if (Auth::check() && Auth::user()->isAdmin()) {
            
            return $next($request);
        }

        // Jika bukan admin, arahkan kembali atau tampilkan error
        // Misalnya, arahkan ke halaman home atau halaman login
        return redirect('/')->with('error', 'Anda tidak memiliki akses Admin.');
    }
}