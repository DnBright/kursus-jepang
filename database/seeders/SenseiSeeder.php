<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sensei;
use Illuminate\Support\Facades\Hash;

class SenseiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sensei::updateOrCreate(
            ['email' => 'sensei@example.com'],
            [
                'name' => 'Ryu Sensei',
                'password' => Hash::make('password'),
                'title' => 'Master of N1',
                'specialization' => 'Advanced Japanese',
                'is_active' => true,
                'status' => 'approved',
            ]
        );
    }
}
