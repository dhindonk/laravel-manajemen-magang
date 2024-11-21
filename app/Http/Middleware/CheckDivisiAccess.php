<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absen;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class CheckDivisiAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->roles->contains('name', 'admin_divisi')) {
            $divisiId = Auth::user()->divisi_id;
            
            // Check for mahasiswa access
            if ($request->route('id')) {
                $mahasiswa = User::find($request->route('id'));
                if ($mahasiswa && $mahasiswa->divisi_id !== $divisiId) {
                    abort(403, 'Unauthorized access.');
                }
            }
            
            // Check for absensi access
            if ($request->is('admin-divisi/absensi/*')) {
                $absen = Absen::find($request->route('id'));
                if ($absen && $absen->user->divisi_id !== $divisiId) {
                    abort(403, 'Unauthorized access.');
                }
            }
            
            // Check for laporan access
            if ($request->is('admin-divisi/laporan/*')) {
                $laporan = Laporan::find($request->route('id'));
                if ($laporan && $laporan->user->divisi_id !== $divisiId) {
                    abort(403, 'Unauthorized access.');
                }
            }
        }

        return $next($request);
    }
}
