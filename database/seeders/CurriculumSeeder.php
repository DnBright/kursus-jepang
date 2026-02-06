<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class CurriculumSeeder extends Seeder
{
    public function run()
    {
        // 1. Basic N5 Course
        $n5 = Course::firstOrCreate(
            ['slug' => 'basic-n5'],
            [
                'title' => 'Basic N5: The Foundation',
                'description' => 'Membangun pondasi bahasa Jepang dari nol. Fokus pada penguasaan huruf, kosakata dasar, dan percakapan harian.',
                'level' => 'Basic N5',
                'price' => 399000,
                'thumbnail' => 'images/n5-thumbnail.jpg'
            ]
        );

        $n5Modules = [
            'Bulan 1: Literacy & Introduction' => [
                ['title' => 'Hiragana Mastery (A-I-U-E-O)', 'type' => 'video', 'duration' => 10],
                ['title' => 'Katakana & Kata Serapan', 'type' => 'video', 'duration' => 12],
                ['title' => 'Salam (Aisatsu) & Angka', 'type' => 'video', 'duration' => 15],
                ['title' => 'Perkenalan Diri (Jikoshoukai)', 'type' => 'video', 'duration' => 20],
                ['title' => 'Quiz: Hiragana & Katakana', 'type' => 'quiz', 'duration' => 15],
            ],
            'Bulan 2: Basic Sentence Structure' => [
                ['title' => 'Pola Kalimat Dasar (A wa B desu)', 'type' => 'video', 'duration' => 15],
                ['title' => 'Kalimat Tanya & Penunjuk Benda', 'type' => 'video', 'duration' => 15],
                ['title' => 'Keberadaan Benda (Arimasu/Imasu)', 'type' => 'video', 'duration' => 18],
                ['title' => 'Waktu & Kata Kerja Bentuk Masu', 'type' => 'video', 'duration' => 20],
            ],
            'Bulan 3: Daily Activities' => [
                ['title' => 'Partikel Gerakan (E, DE, NI)', 'type' => 'video', 'duration' => 15],
                ['title' => 'Mengajak Teman (Mashou ka)', 'type' => 'video', 'duration' => 12],
                ['title' => 'Memberi & Menerima', 'type' => 'video', 'duration' => 15],
                ['title' => 'Kata Sifat (Adj-i & Adj-na)', 'type' => 'video', 'duration' => 20],
                ['title' => 'Final Exam N5', 'type' => 'quiz', 'duration' => 60],
            ]
        ];

        $this->seedModules($n5, $n5Modules);

        // 2. Intensive N4 Course
        $n4 = Course::firstOrCreate(
            ['slug' => 'intensive-n4'],
            [
                'title' => 'Intensive N4: The Accelerator',
                'description' => 'Program percepatan untuk lulus JLPT N4. Fokus pada konjugasi kata kerja, pemahaman bacaan, dan persiapan kerja.',
                'level' => 'Intensive N4',
                'price' => 2250000,
                'thumbnail' => 'images/n4-thumbnail.jpg'
            ]
        );

        $n4Modules = [
            'Bulan 1: Conjugation Mastery' => [
                ['title' => 'Te-Form Mastery (Group 1, 2, 3)', 'type' => 'video', 'duration' => 25],
                ['title' => 'Sedang Melakukan & Ijin (-Te Imasu)', 'type' => 'video', 'duration' => 20],
                ['title' => 'Nai-Form & Dictionary Form', 'type' => 'video', 'duration' => 20],
                ['title' => 'Ta-Form & Past Experience', 'type' => 'video', 'duration' => 15],
                ['title' => 'Casual Speech (Futsuu-kei)', 'type' => 'video', 'duration' => 18],
            ],
            'Bulan 2: Complex Sentences' => [
                ['title' => 'Potential Form (Bisa Melakukan)', 'type' => 'video', 'duration' => 20],
                ['title' => 'Conditional Forms (To, Tara, Ba)', 'type' => 'video', 'duration' => 25],
                ['title' => 'Passive & Causative Forms', 'type' => 'video', 'duration' => 30],
                ['title' => 'Reading Strategy (Dokkai)', 'type' => 'video', 'duration' => 25],
            ],
            'Bulan 3: Professional Prep' => [
                ['title' => 'Keigo (Honorifics) Basics', 'type' => 'video', 'duration' => 30],
                ['title' => 'Listening (Choukai) Tricks', 'type' => 'video', 'duration' => 25],
                ['title' => 'Full JLPT N4 Simulation', 'type' => 'quiz', 'duration' => 120],
            ]
        ];

        $this->seedModules($n4, $n4Modules);
    }

    private function seedModules($course, $modulesData)
    {
        $orderModule = 1;
        foreach ($modulesData as $moduleTitle => $lessons) {
            $module = Module::create([
                'course_id' => $course->id,
                'title' => $moduleTitle,
                'order' => $orderModule++
            ]);

            $orderLesson = 1;
            foreach ($lessons as $lessonData) {
                Lesson::create([
                    'module_id' => $module->id,
                    'title' => $lessonData['title'],
                    'type' => $lessonData['type'],
                    'duration' => $lessonData['duration'],
                    'order' => $orderLesson++,
                    'content' => 'Content placeholder for ' . $lessonData['title']
                ]);
            }
        }
    }
}
