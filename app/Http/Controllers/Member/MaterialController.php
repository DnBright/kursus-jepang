<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // 1. Get all courses the user has purchased
        $levels = $user->transactions()
            ->where('status', 'approved')
            ->pluck('package_type');
            
        $myCourses = Course::whereIn('level', $levels)->get();

        if ($myCourses->isEmpty()) {
            return view('member.materials.index', [
                'myCourses' => collect(),
                'selectedCourse' => null,
                'modules' => collect(),
                'progress' => 0
            ]);
        }

        // 2. Determine which course is currently selected
        $selectedCourseId = $request->get('course_id', $myCourses->first()->id);
        $selectedCourse = $myCourses->firstWhere('id', $selectedCourseId) ?? $myCourses->first();

        // 3. Load modules and lessons for the selected course
        $modules = Module::where('course_id', $selectedCourse->id)
            ->with(['lessons' => function($q) {
                $q->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        // 4. Get completion status for all lessons in this course for this user
        $lessonIds = $modules->pluck('lessons')->flatten()->pluck('id');
        $completedLessonIds = LessonProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $lessonIds)
            ->where('status', 'completed')
            ->pluck('lesson_id')
            ->toArray();

        // 5. Calculate course progress
        $totalLessons = $lessonIds->count();
        $progress = $totalLessons > 0 ? round((count($completedLessonIds) / $totalLessons) * 100) : 0;

        return view('member.materials.index', compact(
            'myCourses', 
            'selectedCourse', 
            'modules', 
            'completedLessonIds', 
            'progress'
        ));
    }
}
