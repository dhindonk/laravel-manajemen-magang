<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DivisiController extends Controller
{
    public function index()
    {
        $divisis = Divisi::with('adminDivisi')->get();
        return view('super_admin.divisi.index', compact('divisis'));
    }

    public function create()
    {
        return view('super_admin.divisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Divisi::create($request->all());

        return redirect()->route('super_admin.divisi.index')
            ->with('success', 'Divisi berhasil ditambahkan');
    }

    public function edit(Divisi $divisi)
    {
        return view('super_admin.divisi.edit', compact('divisi'));
    }

    public function update(Request $request, Divisi $divisi)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $divisi->update($request->all());

        return redirect()->route('super_admin.divisi.index')
            ->with('success', 'Divisi berhasil diupdate');
    }

    public function destroy(Divisi $divisi)
    {
        $divisi->delete();

        return redirect()->route('super_admin.divisi.index')
            ->with('success', 'Divisi berhasil dihapus');
    }
} 