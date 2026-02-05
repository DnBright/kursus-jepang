<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin (in admins table)
        Admin::create([
            'name' => 'Admin LPK',
            'email' => 'admin@kursusjepang.com',
            'password' => 'password',
        ]);

        // Student User (active)
        User::factory()->create([
            'name' => 'Siswa Contoh',
            'email' => 'siswa@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);
        
        // Pending User
        User::factory()->create([
            'name' => 'Siswa Baru',
            'email' => 'baru@example.com',
            'password' => Hash::make('password'),
            'status' => 'pending',
        ]);
    }
}
