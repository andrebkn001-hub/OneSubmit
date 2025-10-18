<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@onesubmit.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Ketua Jurusan',
            'email' => 'jurusan@onesubmit.com',
            'password' => Hash::make('jurusan123'),
            'role' => 'ketua_jurusan',
        ]);

        User::create([
            'name' => 'Ketua KJFD',
            'email' => 'kjfd@onesubmit.com',
            'password' => Hash::make('kjfd123'),
            'role' => 'ketua_kjfd',
        ]);

        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@onesubmit.com',
            'password' => Hash::make('mahasiswa123'),
            'role' => 'mahasiswa',
        ]);
    }
}
