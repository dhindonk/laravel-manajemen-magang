<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'mahasiswa']);

        // Create admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'is_verified' => true,
        ]);
        $admin->assignRole('admin');

        // Create test mahasiswa
        $mahasiswa = User::create([
            'name' => 'Test Mahasiswa',
            'email' => 'mahasiswa@test.com',
            'password' => Hash::make('mahasiswa123'),
            'is_verified' => true,
        ]);
        $mahasiswa->assignRole('mahasiswa');
    }
}
