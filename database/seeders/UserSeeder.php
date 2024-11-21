<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Buat Divisi terlebih dahulu
        $divisiHumas = Divisi::create([
            'nama_divisi' => 'Humas',
            'deskripsi' => 'Divisi Hubungan Masyarakat'
        ]);

        $divisiIT = Divisi::create([
            'nama_divisi' => 'IT',
            'deskripsi' => 'Divisi Teknologi Informasi'
        ]);

        // Buat Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('password'),
            'is_verified' => true,
        ]);
        $superAdmin->assignRole('super_admin');

        // Buat Admin Divisi Humas
        $adminHumas = User::create([
            'name' => 'Admin Humas',
            'email' => 'adminhumas@gmail.com',
            'password' => bcrypt('password'),
            'divisi_id' => $divisiHumas->id,
            'is_verified' => true,
        ]);
        $adminHumas->assignRole('admin_divisi');

        // Buat Admin Divisi IT
        $adminIT = User::create([
            'name' => 'Admin IT',
            'email' => 'adminit@gmail.com',
            'password' => bcrypt('password'),
            'divisi_id' => $divisiIT->id,
            'is_verified' => true,
        ]);
        $adminIT->assignRole('admin_divisi');

        // Buat Mahasiswa (sudah terverifikasi)
        $mahasiswa = User::create([
            'name' => 'John Doe',
            'email' => 'mahasiswa@gmail.com',
            'password' => bcrypt('password'),
            'no_tlpn' => '08123456789',
            'asal_kampus' => 'Universitas ABC',
            'divisi_id' => $divisiIT->id,
            'is_verified' => true,
        ]);
        $mahasiswa->assignRole('mahasiswa');
    }
} 