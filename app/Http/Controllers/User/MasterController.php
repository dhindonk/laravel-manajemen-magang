<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absen;
use App\Models\Laporan;

class MasterController extends Controller
{
    public function index()
    {
        $absens = Absen::where('user_id', Auth::id())->get();
        return view('absens.index', compact('absens'));
    }

    public function create()
    {
        return view('absens.create');
    }

    public function storeabsen(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|string',
            'bukti_foto' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $buktiPath = $request->file('bukti_foto')->store('absen_bukti', 'public');

        Absen::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'bukti_foto' => $buktiPath,
            'keterangan' => $request->keterangan,
            'is_verified' => false,
        ]);

        return redirect()->route('absens.index')->with('success', [
            'title' => 'Berhasil!',
            'message' => 'Absensi berhasil ditambahkan. Tunggu verifikasi dari admin.'
        ]);
    }

    public function createlaporan()
    {
        return view('laporans.create');
    }

    public function storelaporan(Request $request)
    {
        $request->validate([
            'file_laporan' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $filePath = $request->file('file_laporan')->store('laporan_files', 'public');

        Laporan::create([
            'user_id' => Auth::id(),
            'file_laporan' => $filePath,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
            'is_verified' => false,
        ]);

        return redirect()->route('laporans.index')
            ->with('message', 'Laporan berhasil dikirim. Tunggu konfirmasi dari admin.');
    }

    public function indexlaporan()
    {
        $laporans = Laporan::where('user_id', Auth::id())->get();
        return view('laporans.index', compact('laporans'));
    }
}


