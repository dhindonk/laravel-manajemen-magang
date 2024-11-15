<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            Log::info('User roles:', [
                'user_id' => $user->id,
                'roles' => $user->roles->pluck('name')->toArray()
            ]);
            
            if ($user->roles->contains('name', 'admin')) {
                return redirect()->intended('/admin/dashboard')
                    ->with('success', 'Selamat datang, Admin!');
            }
            
            if ($user->roles->contains('name', 'mahasiswa')) {
                if (!$user->is_verified) {
                    Auth::logout();
                    return redirect()->route('login')
                        ->with('error', 'Akun Anda belum diverifikasi. Mohon tunggu verifikasi dari admin.');
                }
                
                return redirect()->intended('/dashboard')
                    ->with('success', 'Selamat datang, ' . $user->name);
            }
        }

        return redirect()->back()
            ->with('error', 'Email atau password salah.')
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('message', 'Berhasil logout');
    }
}
