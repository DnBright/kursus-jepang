<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class AdminGearoffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed as Admin (for /admin/login)
        \App\Models\Admin::updateOrCreate(
            ['email' => 'gearoff@gmail.com'],
            [
                'name' => 'Admin Gearoff',
                'password' => \Illuminate\Support\Facades\Hash::make('Gearoff_JpnAdmin2026_Secure!')
            ]
        );

        // 2. Seed as User (for /login) with admin role
        \App\Models\User::updateOrCreate(
            ['email' => 'gearoff@gmail.com'],
            [
                'name' => 'Admin Gearoff',
                'password' => \Illuminate\Support\Facades\Hash::make('Gearoff_JpnAdmin2026_Secure!'),
                'role' => 'admin',
                'status' => 'active'
            ]
        );
    }
}
