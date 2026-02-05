<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Mock summary stats
        $summary = [
            'total_active' => 45,
            'new_students' => 5,
            'needs_evaluation' => 8,
            'avg_progress' => 68,
        ];

        // Mock students data
        $students = [
            [
                'id' => 1,
                'name' => 'Budi Santoso',
                'class' => 'N5 Intensive A',
                'level' => 'N5',
                'progress' => 85,
                'avg_score' => 92,
                'status' => 'active',
                'trend' => 'up',
                'avatar' => 'BS',
                'joined_at' => '1 Jan 2024',
            ],
            [
                'id' => 2,
                'name' => 'Siti Aminah',
                'class' => 'N4 Regular B',
                'level' => 'N4',
                'progress' => 60,
                'avg_score' => 78,
                'status' => 'active',
                'trend' => 'stable',
                'avatar' => 'SA',
                'joined_at' => '15 Des 2023',
            ],
            [
                'id' => 3,
                'name' => 'Rizky Pratama',
                'class' => 'TG Food Service',
                'level' => 'TG',
                'progress' => 25,
                'avg_score' => 65,
                'status' => 'inactive',
                'trend' => 'down',
                'avatar' => 'RP',
                'joined_at' => '20 Des 2023',
            ],
             [
                'id' => 4,
                'name' => 'Dewi Lestari',
                'class' => 'N5 Intensive A',
                'level' => 'N5',
                'progress' => 95,
                'avg_score' => 98,
                'status' => 'active',
                'trend' => 'up',
                'avatar' => 'DL',
                'joined_at' => '2 Jan 2024',
            ],
            [
                'id' => 5,
                'name' => 'Ahmad Fauzi',
                'class' => 'N4 Regular B',
                'level' => 'N4',
                'progress' => 40,
                'avg_score' => 70,
                'status' => 'warning', // custom status for needs attention
                'trend' => 'down',
                'avatar' => 'AF',
                'joined_at' => '10 Des 2023',
            ],
        ];

        return view('sensei.students.index', compact('summary', 'students'));
    }
}
