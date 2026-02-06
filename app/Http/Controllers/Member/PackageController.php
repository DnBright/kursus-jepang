<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        // We can hardcode packages here or fetch from DB if we had a packages table. 
        // For now, based on previous context, they are hardcoded strings.
        $packages = [
            [
                'name' => 'Basic N5',
                'price' => 399000,
                'original_price' => 599000,
                'features' => ['Video N5 Lengkap', 'E-Book Modul Eksklusif', 'Akses LMS Selamanya', 'Sertifikat Digital'],
                'type' => 'secondary', // for styling
                'badge' => 'Foundation'
            ],
            [
                'name' => 'Intensive N4',
                'price' => 2250000,
                'original_price' => 3000000,
                'features' => ['Live Class Zoom 2x / Week', 'Koreksi Tugas Private', 'Tryout JLPT Real Time', 'Grup Diskusi Premium', 'Job Matching Priority'],
                'type' => 'primary',
                'badge' => 'Intensive',
                'popular' => true
            ],
            [
                'name' => 'Tokutei Ginou',
                'price' => 8500000,
                'original_price' => 12000000,
                'features' => ['Pelatihan Skill Bidang', 'Interview Mockup Session', 'Counseling Preparation', 'Direct Working Visa'],
                'type' => 'secondary',
                'badge' => 'Career'
            ]
        ];

        return view('member.packages.index', compact('packages'));
    }
}
