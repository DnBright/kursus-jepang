<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        // Mock summary stats
        $summary = [
            'active_quizzes' => 8,
            'essay_assignments' => 4,
            'needs_grading' => 25,
            'avg_score' => 86,
        ];

        // Mock quizzes
        $quizzes = [
            [
                'id' => 1,
                'title' => 'Evaluasi Bab 1-5 (Tata Bahasa N5)',
                'level' => 'N5',
                'question_count' => 50,
                'type' => 'Pilihan Ganda',
                'deadline' => '10 Jan 2024',
                'status' => 'active',
            ],
            [
                'id' => 2,
                'title' => 'Latihan Kanji Mingguan',
                'level' => 'N4',
                'question_count' => 20,
                'type' => 'Pilihan Ganda',
                'deadline' => 'Hari Ini',
                'status' => 'active',
            ],
            [
                'id' => 3,
                'title' => 'Ujian Akhir Semester Ganjil',
                'level' => 'N3',
                'question_count' => 100,
                'type' => 'Campuran',
                'deadline' => '-',
                'status' => 'draft',
            ],
        ];

        // Mock assignments (for Manual Grading)
        $assignments = [
            [
                'id' => 101,
                'title' => 'Essay: Ceritakan Liburan Musim Panas',
                'class' => 'N4 Intensive A',
                'submitted_count' => 15,
                'deadline' => 'Kemarin',
                'status' => 'needs_grading', // completed, needs_grading
            ],
             [
                'id' => 102,
                'title' => 'Video: Perkenalan Diri (Jikoshoukai)',
                'class' => 'N5 Basic B',
                'submitted_count' => 20,
                'deadline' => 'Lusa',
                'status' => 'completed',
            ],
        ];

        return view('sensei.quizzes.index', compact('summary', 'quizzes', 'assignments'));
    }
}
