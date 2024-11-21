<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $totalDivisi = Divisi::count();
        $totalAdminDivisi = User::role('admin_divisi')->count();
        $totalMahasiswa = User::role('mahasiswa')->count();
        $pendingVerifikasi = User::role('mahasiswa')
            ->where('is_verified', false)
            ->count();

        $latestMahasiswa = User::role('mahasiswa')
            ->with('divisi')
            ->latest()
            ->take(5)
            ->get();

        return view('super_admin.dashboard', compact(
            'totalDivisi',
            'totalAdminDivisi',
            'totalMahasiswa',
            'pendingVerifikasi',
            'latestMahasiswa'
        ));
    }

    public function verifyUsers()
    {
        $mahasiswas = User::role('mahasiswa')
            ->where('is_verified', false)
            ->latest()
            ->get();

        $divisis = Divisi::all();

        return view('super_admin.verify_users.index', compact('mahasiswas', 'divisis'));
    }

    public function verifyUser(Request $request, $id)
    {
        try {
            $request->validate([
                'divisi_id' => 'required|exists:divisis,id'
            ]);

            $user = User::findOrFail($id);
            $divisi = Divisi::findOrFail($request->divisi_id);
            
            $user->update([
                'is_verified' => true,
                'divisi_id' => $request->divisi_id
            ]);
            
            // Format nomor telepon (hapus karakter selain angka dan pastikan dimulai dengan 62)
            $phone = preg_replace('/[^0-9]/', '', $user->no_tlpn);
            if (substr($phone, 0, 2) !== '62') {
                $phone = '62' . ltrim($phone, '0');
            }
            
            // Buat pesan WhatsApp
            $message = "Halo {$user->name}!\n\n"
                    . "Selamat! Akun Anda telah diverifikasi dan ditempatkan di Divisi {$divisi->nama_divisi}.\n"
                    . "Sekarang Anda dapat login ke sistem magang menggunakan:\n\n"
                    . "Email: {$user->email}\n"
                    . "Password: (password yang Anda daftarkan)\n\n"
                    . "Silakan login dan mulai aktivitas magang Anda.\n"
                    . "Terima kasih.";
                    
            // Buat URL WhatsApp dan langsung redirect
            $whatsappUrl = "https://wa.me/{$phone}?text=" . urlencode($message);
            
            return redirect()->away($whatsappUrl);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memverifikasi mahasiswa');
        }
    }

    public function rejectUser(Request $request, $id)
    {
        try {
            $request->validate([
                'alasan_penolakan' => 'required|string'
            ]);

            $user = User::findOrFail($id);
            
            // Format nomor telepon (hapus karakter selain angka dan pastikan dimulai dengan 62)
            $phone = preg_replace('/[^0-9]/', '', $user->no_tlpn);
            if (substr($phone, 0, 2) !== '62') {
                $phone = '62' . ltrim($phone, '0');
            }
            
            // Buat pesan WhatsApp
            $message = "Halo {$user->name},\n\n"
                    . "Mohon maaf, pendaftaran magang Anda ditolak.\n\n"
                    . "Alasan: {$request->alasan_penolakan}\n\n"
                    . "Silakan perbaiki dokumen Anda dan daftar kembali.\n"
                    . "Terima kasih.";

            // Hapus file yang sudah diupload
            if ($user->surat_kampus) {
                Storage::disk('public')->delete($user->surat_kampus);
            }
            if ($user->surat_bakesbangpol) {
                Storage::disk('public')->delete($user->surat_bakesbangpol);
            }

            // Hapus user
            $user->delete();
                    
            // Buat URL WhatsApp dan langsung redirect
            $whatsappUrl = "https://wa.me/{$phone}?text=" . urlencode($message);
            
            return redirect()->away($whatsappUrl);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menolak mahasiswa');
        }
    }

    public function assignDivisi(Request $request, User $user)
    {
        $request->validate([
            'divisi_id' => 'required|exists:divisis,id'
        ]);

        $user->update([
            'divisi_id' => $request->divisi_id
        ]);

        return redirect()->back()
            ->with('success', 'Mahasiswa berhasil ditugaskan ke divisi');
    }
}
