<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show($courseId, $lessonId)
    {
        $lesson = [];
        $modules = [];

        // Mock Data for "Japanese Culture & Manners" (Course ID 2)
        if ($courseId == 2) {
            $lesson = [
                'id' => $lessonId,
                'course_id' => $courseId,
                'title' => 'Pengenalan Budaya Kerja di Jepang',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Placeholder
                'duration' => '08:45',
                'description' => 'Penjelasan dasar mengenai etos kerja, disiplin, dan kebiasaan umum di lingkungan kerja Jepang.',
                'module_title' => 'Modul 1 – Budaya Kerja Jepang',
                'breadcrumbs' => [
                    'Kursus Saya',
                    'Japanese Culture & Manners',
                    'Modul 1',
                    'Materi'
                ],
                'position' => 'Materi 1 dari 5', // Added dynamic position
                'next_lesson_url' => route('courses.lessons.show', [$courseId, $lessonId + 1]),
                'prev_lesson_url' => null,
            ];

            $modules = [
                [
                    'id' => 1,
                    'title' => 'Modul 1 – Budaya Kerja Jepang',
                    'lessons' => [
                        ['id' => 1, 'title' => 'Materi 1 – Budaya Kerja', 'status' => 'active', 'duration' => '08:45', 'type' => 'video', 'current' => true],
                    ]
                ],
                [
                    'id' => 2,
                    'title' => 'Modul 2 – Etika Berkomunikasi',
                    'lessons' => [
                        ['id' => 2, 'title' => 'Materi 1 – Hourensou', 'status' => 'locked', 'duration' => '10:00', 'type' => 'video'],
                    ]
                ],
                [
                    'id' => 3,
                    'title' => 'Modul 3 – Kehidupan Sehari-hari',
                    'lessons' => []
                ],
                [
                    'id' => 4,
                    'title' => 'Modul 4 – Mindset Kerja',
                    'lessons' => []
                ],
                [
                    'id' => 5,
                    'title' => 'Modul 5 – Studi Kasus',
                    'lessons' => []
                ],
            ];
        } 
        // Mock Data for "Mastering N4 Grammar & Vocab" (Course ID 1)
        else {
            $lesson = [
                'id' => $lessonId,
                'course_id' => $courseId,
                'title' => 'Video 3 – Contoh Percakapan',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Placeholder
                'duration' => '12:30',
                'description' => 'Penjelasan dasar tentang bahasa Jepang, konteks penggunaan, dan sistem penulisan.',
                'module_title' => 'Modul 1 – Pengenalan Bahasa Jepang',
                'breadcrumbs' => [
                    'Kursus Saya',
                    'Mastering N4 Grammar & Vocab',
                    'Modul 1',
                    'Materi'
                ],
                'position' => 'Materi 3 dari 6', // Added dynamic position
                'next_lesson_url' => route('courses.lessons.show', [$courseId, $lessonId + 1]),
                'prev_lesson_url' => $lessonId > 1 ? route('courses.lessons.show', [$courseId, $lessonId - 1]) : null,
            ];

            $modules = [
                 [
                    'id' => 1,
                    'title' => 'Modul 1 – Pengenalan',
                    'lessons' => [
                        ['id' => 1, 'title' => 'Materi 1 – Apa itu Bahasa Jepang', 'status' => 'completed', 'duration' => '10:00', 'type' => 'video'],
                        ['id' => 2, 'title' => 'Materi 2 – Hiragana Dasar', 'status' => 'completed', 'duration' => '15:00', 'type' => 'video'],
                        ['id' => 3, 'title' => 'Materi 3 – Contoh Percakapan', 'status' => 'active', 'duration' => '12:30', 'type' => 'video', 'current' => true], // Current
                        ['id' => 4, 'title' => 'Quiz Modul 1', 'status' => 'locked', 'duration' => '5:00', 'type' => 'quiz'],
                    ]
                ],
                [
                    'id' => 2,
                    'title' => 'Modul 2 – Hiragana Lanjut',
                    'lessons' => [
                        ['id' => 5, 'title' => 'Materi 1 – Dakuten', 'status' => 'locked', 'duration' => '10:00', 'type' => 'video'],
                    ]
                ]
            ];
        }

        return view('member.lessons.show', compact('lesson', 'modules'));
    }
}
