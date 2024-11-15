<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

class VerifyUserController
{
    public function verify(User $user)
    {
        try {
            $user->update(['is_verified' => true]);
            
            // Buat pesan WhatsApp
            $message = "Halo {$user->name}!\n\n"
                    . "Selamat! Akun Anda telah diverifikasi.\n"
                    . "Sekarang Anda dapat login ke sistem magang menggunakan email dan password yang telah didaftarkan.\n\n"
                    . "Terima kasih.";
                    
            // Buat URL WhatsApp
            $whatsappUrl = "https://wa.me/" . $user->no_tlpn . "?text=" . urlencode($message);
            
            return redirect()->back()
                ->with('success', 'Mahasiswa berhasil diverifikasi')
                ->with('whatsapp_url', $whatsappUrl);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memverifikasi mahasiswa');
        }
    }
} 