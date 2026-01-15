<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Akun Admin SDM [cite: 19]
        \App\Models\User::create([
            'name' => 'Admin SDM',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'Admin SDM',
        ]);

        // Akun Manager [cite: 22]
        \App\Models\User::create([
            'name' => 'Manager IT',
            'email' => 'manager@test.com',
            'password' => bcrypt('password'),
            'role' => 'Manager',
            'department' => 'IT',
        ]);

        // Akun Supervisor (SPV) [cite: 21]
        \App\Models\User::create([
            'name' => 'Supervisor Web',
            'email' => 'spv@test.com',
            'password' => bcrypt('password'),
            'role' => 'Supervisor',
            'department' => 'IT',
            'section' => 'Web',
        ]);

        // Akun Karyawan [cite: 20]
        \App\Models\User::create([
            'name' => 'Karyawan Arjun',
            'email' => 'arjun@test.com',
            'password' => bcrypt('password'),
            'role' => 'Karyawan',
            'department' => 'IT',
            'section' => 'Web',
        ]);
    }
}
