<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        // 1. Get all courses with their primary instructors
        $classes = \App\Models\Course::with('instructor')->get()->map(function($course) {
            return (object)[
                'id' => $course->id,
                'name' => $course->title,
                'program_name' => $course->level,
                'sensei_name' => $course->instructor ? $course->instructor->name : '-',
                'student_count' => $course->studentsCount(), // Using model method
                'schedule' => 'Sesuai Jadwal Live', // Dynamic schedule logic could be added later
                'status' => 'active', 
                'created_at' => $course->created_at,
                'price' => 'Rp ' . number_format($course->price, 0, ',', '.'),
                'description' => $course->description,
                'level' => $course->level
            ];
        });

        // 2. Programs (same as classes in this context but could be a different grouping)
        $programs = $classes;
        
        $stats = [
            'total_active_classes' => $classes->count(),
            'total_programs' => $classes->unique('program_name')->count(),
            'popular_class' => $classes->sortByDesc('student_count')->first()->name ?? '-'
        ];

        return view('admin.classes.index', compact('classes', 'programs', 'stats'));
    }

    public function create()
    {
        $instructors = \App\Models\Sensei::where('is_active', true)->get();
        return view('admin.classes.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'instructor_id' => 'required|exists:senseis,id',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|string', // Temporary simple string, can be improved to file upload
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']) . '-' . rand(100, 999);

        \App\Models\Course::create($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas/Program baru berhasil dibuat.');
    }
}
