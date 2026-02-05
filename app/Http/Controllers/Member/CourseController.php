<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show($id)
    {
        // Mock Data for "New Course" / Onboarding
        if ($id == 2) {
            $course = [
                'id' => 2,
                'title' => 'Japanese Culture & Manners',
                'subtitle' => 'Etika kerja dan tata krama sehari-hari yang wajib diketahui sebelum ke Jepang.',
                'progress' => 0,
                'total_modules' => 5,
                'total_hours' => 10,
                // Add any other specific fields needed for intro
            ];
            return view('member.courses.intro', compact('course'));
        }

        // Mock Data for "Completed Course" / Review
        if ($id == 3) {
            $course = [
                'id' => 3,
                'title' => 'Hiragana & Katakana Mastery',
                'subtitle' => 'Fondasi dasar huruf Jepang. Wajib dikuasai sebelum masuk ke Kanji.',
                'progress' => 100,
                'total_modules' => 10,
                'total_hours' => 15,
                'stats' => [
                    'final_score' => 95,
                    'status' => 'Lulus'
                ]
            ];
            return view('member.courses.review', compact('course'));
        }

        // Default Mock Data for "Resuming Course" (ID 1 or others)
        $course = [
            'id' => $id,
            'title' => 'Mastering N4 Grammar & Vocab',
            'subtitle' => 'Persiapan JLPT N4 – Tata Bahasa & Kosakata',
            'progress' => 45,
            'total_modules' => 12,
            'total_hours' => 40,
            'sensei' => [
                'name' => 'Hiroshi Tanako',
                'avatar_url' => 'https://ui-avatars.com/api/?name=Hiroshi+Tanako&background=random'
            ],
            'last_learned' => [
                'module_title' => 'Modul 5 – Pola Kalimat ～ながら',
                'lesson_title' => 'Video 3 – Contoh Percakapan',
            ],
            'modules' => [
                [
                    'id' => 1,
                    'title' => 'Modul 1 – Dasar N4',
                    'status' => 'completed',
                    'lessons' => [
                        ['title' => 'Video 1 - Pengenalan', 'type' => 'video', 'completed' => true],
                        ['title' => 'Quiz Dasar', 'type' => 'quiz', 'completed' => true],
                    ]
                ],
                [
                    'id' => 2,
                    'title' => 'Modul 2 – Partikel Lanjutan',
                    'status' => 'completed',
                    'lessons' => [
                        ['title' => 'Video 1 - Partikel Wa/Ga', 'type' => 'video', 'completed' => true],
                    ]
                ],
                [
                    'id' => 3,
                    'title' => 'Modul 3 – Kanji Dasar',
                    'status' => 'completed',
                    'lessons' => []
                ],
                [
                    'id' => 4,
                    'title' => 'Modul 4 – Tata Bahasa Inti',
                    'status' => 'completed',
                    'lessons' => []
                ],
                [
                    'id' => 5,
                    'title' => 'Modul 5 – Pola Kalimat',
                    'status' => 'active',
                    'lessons' => [
                        ['title' => 'Video 1 - Pola ~Nagara', 'type' => 'video', 'completed' => true],
                        ['title' => 'Video 2 - Contoh Kalimat', 'type' => 'video', 'completed' => true],
                        ['title' => 'Video 3 - Contoh Percakapan', 'type' => 'video', 'completed' => false, 'current' => true],
                        ['title' => 'Latihan Soal', 'type' => 'quiz', 'completed' => false],
                    ]
                ],
                [
                    'id' => 6,
                    'title' => 'Modul 6 – Bacaan Pendek',
                    'status' => 'locked',
                    'lessons' => []
                ],
                // ... assuming more modules for 7-12
            ],
            'stats' => [
                'quiz_score' => 80,
                'avg_score' => 78,
                'status' => 'On Track'
            ]
        ];

        return view('member.courses.show', compact('course'));
    }
}
