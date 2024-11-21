<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_tlpn' => 'required|string',
            'asal_kampus' => 'required|string',
            'surat_kampus' => 'required|file|mimes:pdf|max:2048',
            'surat_bakesbangpol' => 'required|file|mimes:pdf|max:2048',
        ]);

        try {
            // Upload surat kampus
            $suratKampusPath = $request->file('surat_kampus')->store('surat_kampus', 'public');
            
            // Upload surat bakesbangpol
            $suratBakesbangpolPath = $request->file('surat_bakesbangpol')->store('surat_bakesbangpol', 'public');

            // Buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'no_tlpn' => $request->no_tlpn,
                'asal_kampus' => $request->asal_kampus,
                'surat_kampus' => $suratKampusPath,
                'surat_bakesbangpol' => $suratBakesbangpolPath,
                'is_verified' => false,
            ]);

            // Assign role mahasiswa
            $user->assignRole('mahasiswa');

            session(['user' => $user->name]);

            return redirect()->route('register.success')
                ->with('success', 'Pendaftaran berhasil! Silahkan tunggu verifikasi dan penentuan divisi dari admin.');

        } catch (\Exception $e) {
            // Hapus file yang sudah diupload jika terjadi error
            if (isset($suratKampusPath)) {
                Storage::disk('public')->delete($suratKampusPath);
            }
            if (isset($suratBakesbangpolPath)) {
                Storage::disk('public')->delete($suratBakesbangpolPath);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat mendaftar. Silahkan coba lagi.']);
        }
    }

    public function success()
    {
        if (!session('user')) {
            return redirect()->route('register');
        }

        return view('auth.register-success');
    }
}
