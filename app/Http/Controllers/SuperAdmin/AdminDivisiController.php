<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminDivisiController extends Controller
{
    public function index()
    {
        $adminDivisis = User::role('admin_divisi')->with('divisi')->get();
        return view('super_admin.admin_divisi.index', compact('adminDivisis'));
    }

    public function create()
    {
        $divisis = Divisi::all();
        return view('super_admin.admin_divisi.create', compact('divisis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'divisi_id' => 'required|exists:divisis,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'divisi_id' => $request->divisi_id,
        ]);

        $user->assignRole('admin_divisi');

        return redirect()->route('super_admin.admin_divisi.index')
            ->with('success', 'Admin Divisi berhasil ditambahkan');
    }

    public function edit(User $adminDivisi)
    {
        $divisis = Divisi::all();
        return view('super_admin.admin_divisi.edit', compact('adminDivisi', 'divisis'));
    }

    public function update(Request $request, User $adminDivisi)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $adminDivisi->id,
            'password' => 'nullable|string|min:8|confirmed',
            'divisi_id' => 'required|exists:divisis,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'divisi_id' => $request->divisi_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $adminDivisi->update($data);

        return redirect()->route('super_admin.admin_divisi.index')
            ->with('success', 'Admin Divisi berhasil diupdate');
    }

    public function destroy(User $adminDivisi)
    {
        $adminDivisi->delete();

        return redirect()->route('super_admin.admin_divisi.index')
            ->with('success', 'Admin Divisi berhasil dihapus');
    }
} 