<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@kursusjepang.com'],
            [
                'name' => 'Admin Master',
                'password' => bcrypt('admin123'),
            ]
        );

        $this->command->info('Admin berhasil dibuat:');
        $this->command->info('Email: admin@kursusjepang.com');
        $this->command->info('Password: admin123');
    }
}
