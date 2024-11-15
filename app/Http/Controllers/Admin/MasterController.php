<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absen;
use App\Models\Kelas;
use App\Models\SuratBalasan;
use App\Models\Laporan;
use App\Models\SuratSelesai;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        $totalMahasiswa = User::role('mahasiswa')->count();
        $pendingVerifikasi = User::role('mahasiswa')
                                ->where('is_verified', false)
                                ->count();
        $absensiHariIni = Absen::whereDate('created_at', today())
                                ->where('is_verified', false)
                                ->count();

        $mahasiswaTerbaru = User::role('mahasiswa')
                               ->where('is_verified', false)
                               ->latest()
                               ->take(5)
                               ->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'pendingVerifikasi',
            'absensiHariIni',
            'mahasiswaTerbaru'
        ));
    }

    public function verifyUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update(['is_verified' => true]);
            
            // Format nomor telepon (hapus karakter selain angka dan pastikan dimulai dengan 62)
            $phone = preg_replace('/[^0-9]/', '', $user->no_tlpn);
            if (substr($phone, 0, 2) !== '62') {
                $phone = '62' . ltrim($phone, '0');
            }
            
            // Buat pesan WhatsApp
            $message = "Halo {$user->name}!\n\n"
                    . "Selamat! Akun Anda telah diverifikasi.\n"
                    . "Sekarang Anda dapat login ke sistem magang menggunakan email dan password yang telah didaftarkan.\n\n"
                    . "Terima kasih.";
                    
            // Buat URL WhatsApp
            $whatsappUrl = "https://wa.me/{$phone}?text=" . urlencode($message);
            
            return redirect()->back()
                ->with('success', 'Mahasiswa berhasil diverifikasi')
                ->with('whatsapp_url', $whatsappUrl);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memverifikasi mahasiswa');
        }
    }

    public function showSuratBalasanForm($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.surat_balasans.create', compact('user'));
    }

    public function storeSuratBalasan(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'surat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            $suratPath = $request->file('surat')->store('surat_balasans', 'public');

            SuratBalasan::create([
                'user_id' => $request->user_id,
                'surat' => $suratPath,
            ]);

            return redirect()->route('admin.verify.users')
                ->with('success', 'Surat balasan berhasil diupload. Silahkan verifikasi mahasiswa.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupload surat. ' . $e->getMessage());
        }
    }

    public function adminIndex()
    {
        $absens = Absen::all();
        return view('admin.absens.index', compact('absens'));
    }

    public function verifyAbsen($id)
    {
        $absen = Absen::findOrFail($id);
        $absen->is_verified = true;
        $absen->save();

        return redirect()->route('admin.absens.index')->with('success', [
            'title' => 'Verifikasi Berhasil!',
            'message' => 'Absensi mahasiswa telah diverifikasi.'
        ]);
    }

    public function verifyUsersIndex()
    {
        $users = User::role('mahasiswa')
                     ->get();
        return view('admin.verify_users.index', compact('users'));
    }

    public function suratBalasansIndex()
    {
        $users = User::role('mahasiswa')
                     ->where('is_verified', true)
                     ->whereDoesntHave('suratBalasan')
                     ->get();
        return view('admin.surat_balasans.index', compact('users'));
    }

    public function absensIndex()
    {
        $absens = Absen::with('user')
                       ->get();
        return view('admin.absens.index', compact('absens'));
    }

    public function laporansIndex()
    {
        $laporans = Laporan::with(['user', 'suratSelesai'])->get();
        return view('admin.laporans.index', compact('laporans'));
    }

    public function createSuratSelesai($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('admin.laporans.create_surat', compact('laporan'));
    }

    public function storeSuratSelesai(Request $request, $id)
    {
        $request->validate([
            'file_surat' => 'required|file|mimes:pdf|max:2048',
            'tanggal_surat' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $suratPath = $request->file('file_surat')->store('surat_selesai_files', 'public');

        SuratSelesai::create([
            'laporan_id' => $id,
            'file_surat' => $suratPath,
            'tanggal_surat' => $request->tanggal_surat,
            'keterangan' => $request->keterangan,
        ]);

        // Update status laporan
        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status' => 'diterima',
            'is_verified' => true
        ]);

        return redirect()->route('admin.suratselesai.index')
            ->with('message', 'Surat selesai berhasil dibuat dan laporan telah diverifikasi.');
    }

    public function suratSelesaiIndex()
    {
        $laporans = Laporan::with(['user', 'suratSelesai'])->get();
        return view('admin.suratselesai.index', compact('laporans'));
    }

}
