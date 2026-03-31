<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        // 1. Get all lessons (Materials) categorized by type
        $allLessons = \App\Models\Lesson::with(['module.course'])->get();
        
        $materials = $allLessons->where('type', '!=', 'pdf')->map(function($lesson) {
            return (object)[
                'id' => $lesson->id,
                'title' => $lesson->title,
                'program' => $lesson->module && $lesson->module->course ? $lesson->module->course->level : '-',
                'class_name' => $lesson->module && $lesson->module->course ? $lesson->module->course->title : '-',
                'type' => $lesson->type,
                'status' => 'active',
                'last_updated' => $lesson->updated_at
            ];
        });

        $files = $allLessons->where('type', 'pdf')->map(function($lesson) {
            return (object)[
                'id' => $lesson->id,
                'name' => $lesson->title . '.pdf',
                'type' => 'PDF',
                'program' => $lesson->module && $lesson->module->course ? $lesson->module->course->level : '-',
                'size' => 'Auto', 
                'status' => 'active'
            ];
        });

        // 2. Get all quizzes
        $quizzes = \App\Models\Quiz::with(['lesson.module.course', 'questions'])->get()->map(function($quiz) {
            return (object)[
                'id' => $quiz->id,
                'title' => $quiz->title,
                'level' => $quiz->lesson && $quiz->lesson->module && $quiz->lesson->module->course ? $quiz->lesson->module->course->level : ($quiz->difficulty ?? '-'),
                'class_name' => $quiz->lesson && $quiz->lesson->module && $quiz->lesson->module->course ? $quiz->lesson->module->course->title : '-',
                'question_count' => $quiz->questions->count(),
                'status' => $quiz->is_active ? 'active' : 'draft'
            ];
        });
        
        $stats = [
            'total_materials' => $materials->count(),
            'total_files' => $files->count(),
            'total_quizzes' => $quizzes->count()
        ];

        return view('admin.materials.index', compact('materials', 'files', 'quizzes', 'stats'));
    }
}
