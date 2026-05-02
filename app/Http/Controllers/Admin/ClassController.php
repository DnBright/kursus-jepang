<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        // 1. Get all courses with their primary instructors
        $courses = \App\Models\Course::with('instructor')->get();
        
        $classes = $courses->map(function($course) {
            $studentCount = $course->studentsCount();
            // Determine status based on student enrollment and course data
            $status = 'active';
            if ($studentCount === 0 && $course->created_at->diffInDays(now()) > 30) {
                $status = 'draft';
            } elseif ($studentCount > 0 && $studentCount < 5) {
                $status = 'active';
            }
            
            return (object)[
                'id' => $course->id,
                'name' => $course->title,
                'program_name' => $course->level,
                'sensei_name' => $course->instructor ? $course->instructor->name : '-',
                'student_count' => $studentCount,
                'schedule' => 'Jadwal Flexible', 
                'status' => $status,
                'created_at' => $course->created_at,
                'price' => 'Rp ' . number_format($course->price, 0, ',', '.'),
                'description' => $course->description,
                'level' => $course->level,
                'instructor_id' => $course->instructor_id,
                'slug' => $course->slug
            ];
        });

        // 2. Programs (same as classes in this context but could be a different grouping)
        $programs = $classes;
        
        $stats = [
            'total_active_classes' => $classes->where('status', 'active')->count(),
            'total_programs' => $classes->unique('program_name')->count(),
            'popular_class' => $classes->sortByDesc('student_count')->first()->name ?? '-',
            'total_students' => $classes->sum('student_count')
        ];

        $instructors = \App\Models\Sensei::where('is_active', true)->get();

        return view('admin.classes.index', compact('classes', 'programs', 'stats', 'instructors'));
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

    public function update(Request $request, $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|string|max:50',
            'price' => 'nullable|numeric|min:0',
            'instructor_id' => 'nullable|exists:senseis,id',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|string',
        ]);

        // Update slug if title changed
        if ($request->has('title') && $request->title !== $course->title) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']) . '-' . rand(100, 999);
        }

        $course->update($validated);

        return redirect()->route('admin.classes.index')->with('success', 'Kelas/Program berhasil diperbarui.');
    }
}
