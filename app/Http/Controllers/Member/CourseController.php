<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        // Get only courses the user has purchased
        $user = Auth::user();
        
        $courses = Course::with('modules')
            ->get()
            ->filter(function($course) use ($user) {
                return $user->hasActivePackage($course->level);
            });

        return view('member.courses.index', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::with(['modules.lessons', 'instructor'])->findOrFail($id);

        if (!Auth::user()->hasActivePackage($course->level)) {
            return redirect()->route('packages.index')->with('error', 'Anda harus membeli paket ini terlebih dahulu.');
        }

        // Calculate Progress
        $allLessons = $course->modules->flatMap->lessons;
        $totalLessons = $allLessons->count();
        $completedLessonsCount = \App\Models\LessonProgress::where('user_id', Auth::id())
            ->whereIn('lesson_id', $allLessons->pluck('id'))
            ->where('status', 'completed')
            ->count();
        
        $progress = $totalLessons > 0 ? round(($completedLessonsCount / $totalLessons) * 100) : 0;

        return view('member.courses.show', compact('course', 'progress'));
    }
}
