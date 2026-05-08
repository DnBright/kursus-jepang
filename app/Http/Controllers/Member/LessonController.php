<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show($courseId, $lessonId)
    {
        // Load course with modules and lessons sorted by their sequence/ID
        $course = Course::with(['modules' => function($q) {
            $q->orderBy('id', 'asc');
        }, 'modules.lessons' => function($q) {
            $q->orderBy('id', 'asc');
        }])->findOrFail($courseId);
        
        if (!Auth::user()->hasActivePackage($course->level)) {
            return redirect()->route('packages.index')->with('error', 'Akses ditolak.');
        }

        $lesson = Lesson::whereHas('module', function($q) use ($courseId) {
                        $q->where('course_id', $courseId);
                    })
                    ->with('module')
                    ->findOrFail($lessonId);

        // Flatten all lessons across all modules to find the global position
        $allLessons = $course->modules->flatMap(function($module) {
            return $module->lessons;
        });

        // Use strict check or ensure IDs are of same type
        $currentIndex = $allLessons->search(function($item) use ($lessonId) {
            return (int)$item->id === (int)$lessonId;
        });

        $prevLesson = ($currentIndex !== false && $currentIndex > 0) ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = ($currentIndex !== false && $currentIndex < $allLessons->count() - 1) ? $allLessons[$currentIndex + 1] : null;

        // Breadcrumbs
        $breadcrumbs = [
            'Kursus Saya',
            $course->title,
            $lesson->module->title,
            'Materi'
        ];

        // Prepare data for view
        $data = [
            'course' => $course,
            'lesson' => $lesson,
            'modules' => $course->modules,
            'prev_lesson_url' => $prevLesson ? route('courses.lessons.show', [$course->id, $prevLesson->id]) : null,
            'next_lesson_url' => $nextLesson ? route('courses.lessons.show', [$course->id, $nextLesson->id]) : null,
            'position' => 'Materi ' . ($currentIndex !== false ? ($currentIndex + 1) : 0) . ' dari ' . $allLessons->count(),
            'breadcrumbs' => $breadcrumbs,
        ];

        return view('member.lessons.show', $data);
    }
}
