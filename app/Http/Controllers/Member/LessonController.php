<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show($courseId, $lessonId)
    {
        $course = Course::with(['modules.lessons'])->findOrFail($courseId);
        $lesson = Lesson::whereHas('module', function($q) use ($courseId) {
                        $q->where('course_id', $courseId);
                    })
                    ->findOrFail($lessonId);

        // Find Next and Prev Lesson
        // Flatten all lessons to find position
        $allLessons = $course->modules->flatMap->lessons;
        $currentIndex = $allLessons->search(function($item) use ($lessonId) {
            return $item->id == $lessonId;
        });

        $prevLesson = $currentIndex > 0 ? $allLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $allLessons->count() - 1 ? $allLessons[$currentIndex + 1] : null;

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
            'position' => 'Materi ' . ($currentIndex + 1) . ' dari ' . $allLessons->count(),
            'breadcrumbs' => $breadcrumbs,
        ];

        return view('member.lessons.show', $data);
    }
}
