<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN UTAMA (NIM diisi 'admin' agar database tidak menolak)
        if (!User::where('email', 'admin@onesubmit.com')->exists()) {
            User::create([
                'name' => 'Admin Utama',
                'email' => 'admin@onesubmit.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'nim' => 'admin', 
                'email_verified_at' => now(),
            ]);
        }

        // KETUA JURUSAN
        if (!User::where('email', 'jurusan@onesubmit.com')->exists()) {
            User::create([
                'name' => 'Ketua Jurusan',
                'email' => 'jurusan@onesubmit.com',
                'password' => Hash::make('jurusan123'),
                'role' => 'ketua_jurusan',
                'nim' => 'kajur',
                'email_verified_at' => now(),
            ]);
        }

        // DOSEN KJFD - IM
        if (!User::where('email', 'kjfd_im@onesubmit.com')->exists()) {
            User::create([
                'name' => 'KJFD Information Management',
                'email' => 'kjfd_im@onesubmit.com',
                'password' => Hash::make('kjfd123'),
                'role' => 'dosen_kjfd',
                'nim' => 'kjfd_im',
                'bidang' => 'Information Management',
                'email_verified_at' => now(),
            ]);
        }

        // DOSEN KJFD - BI
        if (!User::where('email', 'kjfd_bi@onesubmit.com')->exists()) {
            User::create([
                'name' => 'KJFD Business Intelligence',
                'email' => 'kjfd_bi@onesubmit.com',
                'password' => Hash::make('kjfd123'),
                'role' => 'dosen_kjfd',
                'nim' => 'kjfd_bi',
                'bidang' => 'Business Intelligence',
                'email_verified_at' => now(),
            ]);
        }

        // DOSEN KJFD - DE
        if (!User::where('email', 'kjfd_de@onesubmit.com')->exists()) {
            User::create([
                'name' => 'KJFD Data Engineering',
                'email' => 'kjfd_de@onesubmit.com',
                'password' => Hash::make('kjfd123'),
                'role' => 'dosen_kjfd',
                'nim' => 'kjfd_de',
                'bidang' => 'Data Engineering',
                'email_verified_at' => now(),
            ]);
        }

        // DOSEN KJFD - IR
        if (!User::where('email', 'kjfd_ir@onesubmit.com')->exists()) {
            User::create([
                'name' => 'KJFD Information Retrieval',
                'email' => 'kjfd_ir@onesubmit.com',
                'password' => Hash::make('kjfd123'),
                'role' => 'dosen_kjfd',
                'nim' => 'kjfd_ir',
                'bidang' => 'Information Retrieval',
                'email_verified_at' => now(),
            ]);
        }

        // MAHASISWA (Ini memang butuh NIM asli)
        if (!User::where('email', 'mahasiswa@onesubmit.com')->exists()) {
            User::create([
                'name' => 'Mahasiswa',
                'email' => 'mahasiswa@onesubmit.com',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
                'nim' => '1234567890',
                'email_verified_at' => now(),
            ]);
        }
    }
}
