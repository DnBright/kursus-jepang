<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Mock Configuration Data
        $settings = [
            'general' => [
                'platform_name' => 'Kursus Jepang',
                'email' => 'admin@kursusjepang.com',
                'language' => 'Indonesia',
                'timezone' => 'Asia/Jakarta'
            ],
            'account' => [
                'manual_approval' => true,
                'allow_registration' => true
            ],
            'course' => [
                'active_levels' => ['N5', 'N4', 'Tokutei Ginou'],
                'curriculum' => 'modular',
                'min_progress' => 100
            ],
            'payment' => [
                'currency' => 'IDR',
                'methods' => ['Bank Transfer', 'E-Wallet', 'QRIS'],
                'auto_confirm' => false
            ],
            'certificate' => [
                'auto_generate' => true,
                'format' => 'KJ-{YEAR}-{MONTH}-{NUM}',
                'default_template' => 'Standard N5'
            ]
        ];

        return view('admin.settings.index', compact('settings'));
    }
}
