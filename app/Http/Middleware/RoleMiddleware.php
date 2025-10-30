<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Pastikan user sudah login
        if (!$request->user()) {
             // Jika belum login, redirect ke halaman login (standard Laravel)
             return redirect('/login'); 
        }
        
        // 2. Ubah string roles menjadi array
        // Misalnya 'admin,bidan' menjadi ['admin', 'bidan']
        $allowedRoles = is_array($role) ? $role : explode(',', $role);
        
        // 3. Periksa apakah role user ada di dalam daftar role yang diizinkan
        if (!in_array($request->user()->role, $allowedRoles)) {
            // Jika role user TIDAK ADA dalam daftar yang diizinkan, tolak akses.
            abort(403, 'Akses Ditolak: Anda tidak memiliki hak akses.');
        }
        
        // Lolos, lanjutkan ke request berikutnya
        return $next($request);
    }
}