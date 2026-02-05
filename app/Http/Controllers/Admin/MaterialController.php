<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        // Mock Materials (Video/Text)
        $materials = collect([
            (object)[
                'id' => 1,
                'title' => 'Pengenalan Hiragana Dasar',
                'program' => 'N5 Basic',
                'class_name' => 'N5 Basic Batch 20',
                'type' => 'video',
                'status' => 'active',
                'last_updated' => now()->subDays(2)
            ],
            (object)[
                'id' => 2,
                'title' => 'Partikel Wa dan Ga',
                'program' => 'N5 Intensive',
                'class_name' => 'N5 Intensive Batch 12',
                'type' => 'text',
                'status' => 'active',
                'last_updated' => now()->subWeek()
            ],
             (object)[
                'id' => 3,
                'title' => 'Conversation Practice 1',
                'program' => 'N4 Regular',
                'class_name' => 'N4 Regular Batch 5',
                'type' => 'audio',
                'status' => 'draft',
                'last_updated' => now()->subHours(5)
            ]
        ]);

        // Mock Files (PDF/Doc)
        $files = collect([
            (object)[
                'id' => 1,
                'name' => 'Modul Hiragana Lengkap.pdf',
                'type' => 'PDF',
                'program' => 'N5 Basic',
                'size' => '2.5 MB',
                'status' => 'active'
            ],
            (object)[
                'id' => 2,
                'name' => 'Latihan Soal Partikel.docx',
                'type' => 'DOC',
                'program' => 'N5 Intensive',
                'size' => '500 KB',
                'status' => 'active'
            ]
        ]);

        // Mock Quizzes
        $quizzes = collect([
             (object)[
                'id' => 1,
                'title' => 'Quiz Hiragana 1',
                'level' => 'N5',
                'class_name' => 'N5 Basic Batch 20',
                'question_count' => 20,
                'status' => 'active'
            ],
             (object)[
                'id' => 2,
                'title' => 'Ujian Tengah Semester',
                'level' => 'N4',
                'class_name' => 'N4 Regular Batch 5',
                'question_count' => 50,
                'status' => 'scheduled'
            ]
        ]);
        
        $stats = [
            'total_materials' => $materials->count(),
            'total_files' => $files->count(),
            'total_quizzes' => $quizzes->count()
        ];

        return view('admin.materials.index', compact('materials', 'files', 'quizzes', 'stats'));
    }
}
