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
}
