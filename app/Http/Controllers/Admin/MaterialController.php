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

    public function create()
    {
        $courses = \App\Models\Course::with('modules')->get();
        $instructors = \App\Models\Sensei::where('is_active', true)->get();
        return view('admin.materials.create', compact('courses', 'instructors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'instructor_id' => 'required|exists:senseis,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,text,audio,pdf',
            'content' => 'required|string',
            'duration' => 'nullable|string',
            'order' => 'required|integer|min:1',
            'is_free' => 'boolean',
        ]);

        \App\Models\Lesson::create($validated);

        return redirect()->route('admin.materials.index')->with('success', 'Materi baru berhasil ditambahkan.');
    }
}
