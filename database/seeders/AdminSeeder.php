<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Panitia
        User::create([
            'name'     => 'Panitia PPDB',
            'email'    => 'panitia@gmail.com',
            'password' => bcrypt('password123'),
            'role'     => 'panitia',
        ]);

        // Akun Pimpinan
        User::create([
            'name'     => 'Pimpinan Pondok',
            'email'    => 'pimpinan@gmail.com',
            'password' => bcrypt('password123'),
            'role'     => 'pimpinan',
        ]);

        // Akun Contoh Calon Santri
        User::create([
            'name'     => 'Calon Santri Contoh',
            'email'    => 'santri@gmail.com',
            'password' => bcrypt('password123'),
            'role'     => 'calon santri',
        ]);
    }
}