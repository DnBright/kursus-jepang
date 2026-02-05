<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        // Mock Classes Data
        $classes = collect([
            (object)[
                'id' => 1,
                'name' => 'N5 Intensive Batch 12',
                'program_name' => 'N5 Intensive',
                'sensei_name' => 'Tanaka Ken',
                'student_count' => 18,
                'schedule' => 'Senin, Rabu, Jumat (19:00)',
                'status' => 'active', // active, finished, draft
                'created_at' => now()->subWeeks(4)
            ],
            (object)[
                'id' => 2,
                'name' => 'N4 Regular Batch 5',
                'program_name' => 'N4 Regular',
                'sensei_name' => 'Sato Yuki',
                'student_count' => 12,
                'schedule' => 'Selasa, Kamis (20:00)',
                'status' => 'active',
                'created_at' => now()->subWeeks(8)
            ],
             (object)[
                'id' => 3,
                'name' => 'N5 Basic Batch 20',
                'program_name' => 'N5 Basic',
                'sensei_name' => '-',
                'student_count' => 0,
                'schedule' => 'Belum ditentukan',
                'status' => 'draft',
                'created_at' => now()->subDay()
            ]
        ]);

        // Mock Programs Data
        $programs = collect([
            (object)[
                'id' => 1,
                'name' => 'N5 Intensive',
                'level' => 'N5',
                'description' => 'Program intensif persiapan JLPT N5 dalam 3 bulan.',
                'duration' => '3 Bulan',
                'price' => 'Rp 2.500.000',
                'status' => 'active'
            ],
             (object)[
                'id' => 2,
                'name' => 'N4 Regular',
                'level' => 'N4',
                'description' => 'Program lanjutan santai untuk level N4.',
                'duration' => '6 Bulan',
                'price' => 'Rp 3.000.000',
                'status' => 'active'
            ],
             (object)[
                'id' => 3,
                'name' => 'Tokutei Ginou Kaigo',
                'level' => 'N4/TG',
                'description' => 'Persiapan khusus skill workers bidang care worker.',
                'duration' => '4 Bulan',
                'price' => 'Rp 5.000.000',
                'status' => 'active'
            ]
        ]);
        
        $stats = [
            'total_active_classes' => $classes->where('status', 'active')->count(),
            'total_programs' => $programs->count(),
            'popular_class' => $classes->sortByDesc('student_count')->first()->name ?? '-'
        ];

        return view('admin.classes.index', compact('classes', 'programs', 'stats'));
    }
}
