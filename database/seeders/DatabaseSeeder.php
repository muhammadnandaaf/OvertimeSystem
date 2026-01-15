<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin SDM',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'Admin SDM',
        ]);

        \App\Models\User::create([
            'name' => 'Manager IT',
            'email' => 'manager@test.com',
            'password' => bcrypt('password'),
            'role' => 'Manager',
            'department' => 'IT',
        ]);

        \App\Models\User::create([
            'name' => 'Supervisor Web',
            'email' => 'spv@test.com',
            'password' => bcrypt('password'),
            'role' => 'Supervisor',
            'department' => 'IT',
            'section' => 'Web',
        ]);

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
