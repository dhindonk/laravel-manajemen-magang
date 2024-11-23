<?php

namespace App\Http\Controllers\AdminDivisi;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Absen;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDivisiController extends Controller
{
    public function dashboard()
    {
        $divisi = Auth::user()->divisi;
        $totalMahasiswa = User::role('mahasiswa')
                             ->where('divisi_id', $divisi->id)
                             ->count();
                             
        $pendingAbsensi = Absen::whereHas('user', function($q) use ($divisi) {
                                $q->where('divisi_id', $divisi->id);
                             })
                             ->where('is_verified', false)
                             ->count();
                             
        $pendingLaporan = Laporan::whereHas('user', function($q) use ($divisi) {
                                $q->where('divisi_id', $divisi->id);
                             })
                             ->where('is_verified', false)
                             ->count();

        $latestMahasiswa = User::role('mahasiswa')
                              ->where('divisi_id', $divisi->id)
                              ->latest()
                              ->take(5)
                              ->get();

        return view('admin_divisi.dashboard', compact(
            'divisi',
            'totalMahasiswa',
            'pendingAbsensi',
            'pendingLaporan',
            'latestMahasiswa'
        ));
    }

    public function mahasiswa()
    {
        $divisiId = Auth::user()->divisi_id;
        $mahasiswas = User::role('mahasiswa')
                         ->where('divisi_id', $divisiId)
                         ->get();

        return view('admin_divisi.mahasiswa.index', compact('mahasiswas'));
    }

    public function absensi()
    {
        $absens = Absen::whereHas('user', function($q) {
                    $q->where('divisi_id', Auth::user()->divisi_id);
                 })
                 ->with('user')
                 ->latest()
                 ->get();

        return view('admin_divisi.absensi.index', compact('absens'));
    }

    public function verifyAbsen($id)
    {
        $absen = Absen::whereHas('user', function($q) {
                    $q->where('divisi_id', Auth::user()->divisi_id);
                 })
                 ->findOrFail($id);

        $absen->update(['is_verified' => true]);

        return redirect()->back()
            ->with('success', 'Absensi berhasil diverifikasi');
    }

    public function laporan()
    {
        $laporans = Laporan::whereHas('user', function($q) {
                        $q->where('divisi_id', Auth::user()->divisi_id);
                     })
                     ->with(['user', 'suratSelesai'])
                     ->latest()
                     ->get();

        return view('admin_divisi.laporan.index', compact('laporans'));
    }

    public function verifyLaporan($id)
    {
        $laporan = Laporan::whereHas('user', function($q) {
                        $q->where('divisi_id', Auth::user()->divisi_id);
                     })
                     ->findOrFail($id);

        // Validasi request untuk surat selesai
        request()->validate([
            'file_surat' => 'required|file|mimes:pdf|max:2048',
            'tanggal_surat' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Upload surat selesai
        $suratPath = request()->file('file_surat')->store('surat_selesai_files', 'public');

        // Buat surat selesai
        $laporan->suratSelesai()->create([
            'file_surat' => $suratPath,
            'tanggal_surat' => request()->tanggal_surat,
            'keterangan' => request()->keterangan,
        ]);

        // Update status laporan
        $laporan->update([
            'is_verified' => true,
            'status' => 'diterima'
        ]);

        return redirect()->back()
            ->with('success', 'Laporan berhasil diverifikasi dan surat selesai telah dibuat');
    }

    public function rejectLaporan(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string'
        ]);

        $laporan = Laporan::whereHas('user', function($q) {
                        $q->where('divisi_id', Auth::user()->divisi_id);
                     })
                     ->findOrFail($id);

        $laporan->update([
            'status' => 'ditolak',
            'keterangan' => $request->keterangan
        ]);

        return redirect()->back()
            ->with('success', 'Laporan berhasil ditolak');
    }
} 