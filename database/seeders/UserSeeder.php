<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Only create users if they don't already exist
        if (!User::where('email', 'admin@onesubmit.com')->exists()) {
            User::create([
                'name' => 'Admin Utama',
                'email' => 'admin@onesubmit.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'jurusan@onesubmit.com')->exists()) {
            User::create([
                'name' => 'Ketua Jurusan',
                'email' => 'jurusan@onesubmit.com',
                'password' => Hash::make('jurusan123'),
                'role' => 'ketua_jurusan',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'kjfd_im@onesubmit.com')->exists()) {
            User::create([
                'name' => 'KJFD Information Management',
                'email' => 'kjfd_im@onesubmit.com',
                'password' => Hash::make('kjfd123'),
                'role' => 'dosen_kjfd',
                'bidang' => 'Information Management',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'kjfd_bi@onesubmit.com')->exists()) {
            User::create([
                'name' => 'KJFD Business Intelligence',
                'email' => 'kjfd_bi@onesubmit.com',
                'password' => Hash::make('kjfd123'),
                'role' => 'dosen_kjfd',
                'bidang' => 'Business Intelligence',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'kjfd_de@onesubmit.com')->exists()) {
            User::create([
                'name' => 'KJFD Data Engineering',
                'email' => 'kjfd_de@onesubmit.com',
                'password' => Hash::make('kjfd123'),
                'role' => 'dosen_kjfd',
                'bidang' => 'Data Engineering',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'kjfd_ir@onesubmit.com')->exists()) {
            User::create([
                'name' => 'KJFD Information Retrieval',
                'email' => 'kjfd_ir@onesubmit.com',
                'password' => Hash::make('kjfd123'),
                'role' => 'dosen_kjfd',
                'bidang' => 'Information Retrieval',
                'email_verified_at' => now(),
            ]);
        }

        if (!User::where('email', 'mahasiswa@onesubmit.com')->exists()) {
            User::create([
                'name' => 'Mahasiswa',
                'email' => 'mahasiswa@onesubmit.com',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
            ]);
        }
    }
}
