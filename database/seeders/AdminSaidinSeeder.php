<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSaidinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin::updateOrCreate(
            ['email' => 'saidin21@gmail.com'],
            [
                'name' => 'Admin Saidin',
                'password' => \Illuminate\Support\Facades\Hash::make('Admin_Saidin123!')
            ]
        );
    }
}
