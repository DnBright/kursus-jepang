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
        $selectedLevel = $request->get('level', 'all');
        
        // 1. Get all package types the user has purchased
        $purchasedLevels = $user->transactions()
            ->where('status', 'approved')
            ->pluck('package_type')
            ->toArray();
            
        // 2. Filter courses based on purchased levels AND optional level filter
        $myCoursesQuery = Course::where(function($q) use ($purchasedLevels) {
            foreach ($purchasedLevels as $pl) {
                $q->orWhere('level', 'like', "%$pl%")
                  ->orWhere('title', 'like', "%$pl%");
            }
        });

        if ($selectedLevel !== 'all') {
            $myCoursesQuery->where('level', 'like', "%$selectedLevel%");
        }

        $myCourses = $myCoursesQuery->get();

        if ($myCourses->isEmpty()) {
            return view('member.materials.index', [
                'myCourses' => collect(),
                'selectedCourse' => null,
                'modules' => collect(),
                'progress' => 0,
                'selectedLevel' => $selectedLevel,
                'purchasedLevels' => $purchasedLevels
            ]);
        }

        // 3. Determine which course is currently selected
        $selectedCourseId = $request->get('course_id');
        if ($selectedCourseId) {
            $selectedCourse = $myCourses->firstWhere('id', $selectedCourseId);
            // If they try to access a course ID they don't own, fallback to first owned course
            if (!$selectedCourse) {
                $selectedCourse = $myCourses->first();
            }
        } else {
            $selectedCourse = $myCourses->first();
        }

        // 4. Load modules and lessons for all filtered courses
        $courseIds = $myCourses->pluck('id');
        $modules = Module::whereIn('course_id', $courseIds)
            ->with(['lessons' => function($q) {
                $q->orderBy('order');
            }])
            ->orderBy('course_id')
            ->orderBy('order')
            ->get();

        // 5. Get completion status for all lessons in these courses for this user
        $lessonIds = $modules->pluck('lessons')->flatten()->pluck('id');
        $completedLessonIds = LessonProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $lessonIds)
            ->where('status', 'completed')
            ->pluck('lesson_id')
            ->toArray();

        // 6. Calculate program progress
        $totalLessons = $lessonIds->count();
        $progress = $totalLessons > 0 ? round((count($completedLessonIds) / $totalLessons) * 100) : 0;

        return view('member.materials.index', compact(
            'myCourses', 
            'selectedCourse', 
            'modules', 
            'completedLessonIds', 
            'progress',
            'selectedLevel',
            'purchasedLevels'
        ));
    }
}
