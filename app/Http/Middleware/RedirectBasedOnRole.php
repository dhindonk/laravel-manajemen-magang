<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->roles->contains('name', 'super_admin')) {
                return redirect()->route('super_admin.dashboard');
            }
            
            if (Auth::user()->roles->contains('name', 'admin_divisi')) {
                return redirect()->route('admin_divisi.dashboard');
            }
            
            if (Auth::user()->roles->contains('name', 'mahasiswa')) {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
} 