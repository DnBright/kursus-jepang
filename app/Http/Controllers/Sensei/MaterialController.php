<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        // Mock summary stats
        $summary = [
            'active_materials' => 45,
            'total_modules' => 12,
            'popular_material' => 'Video: Partikel Dasar',
            'draft_materials' => 3,
        ];

        // Mock modules structure
        $modules = [
            [
                'id' => 1,
                'title' => 'Dasar Tata Bahasa N5',
                'level' => 'N5',
                'material_count' => 8,
                'status' => 'published',
                'materials' => [
                    [
                        'id' => 101,
                        'title' => 'Pengenalan Huruf Hiragana & Katakana',
                        'type' => 'PDF',
                        'students_access' => 120,
                        'status' => 'published',
                    ],
                    [
                        'id' => 102,
                        'title' => 'Video Penjelasan Partikel WA, NI, DE',
                        'type' => 'Video',
                        'students_access' => 95,
                        'status' => 'published',
                    ],
                    [
                        'id' => 103,
                        'title' => 'Latihan Soal Partikel Dasar',
                        'type' => 'Quiz',
                        'students_access' => 88,
                        'status' => 'draft',
                    ]
                ]
            ],
            [
                'id' => 2,
                'title' => 'Percakapan Sehari-hari (Kaiwa)',
                'level' => 'N4',
                'material_count' => 5,
                'status' => 'published',
                'materials' => [
                     [
                        'id' => 201,
                        'title' => 'Video Situasi di Restoran',
                        'type' => 'Video',
                        'students_access' => 45,
                        'status' => 'published',
                    ],
                ]
            ],
             [
                'id' => 3,
                'title' => 'Persiapan Tokutei Ginou: Food Service',
                'level' => 'TG',
                'material_count' => 0,
                'status' => 'draft',
                'materials' => []
            ]
        ];

        return view('sensei.materials.index', compact('summary', 'modules'));
    }
}
