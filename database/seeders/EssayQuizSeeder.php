<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\User;
use App\Models\UserQuizAttempt;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EssayQuizSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create an N5 Essay Quiz
        $n5Course = Course::where('level', 'Basic N5')->first();
        $instructorId = DB::table('senseis')->first()->id ?? 1;

        $essayQuiz = Quiz::create([
            'title' => 'Latihan Menulis: Budaya & Etika',
            'description' => 'Uji kemampuan menulis dan pemahaman budaya Jepang Anda melalui soal essai ini.',
            'instructor_id' => $instructorId,
            'type' => 'weekly',
            'difficulty' => 'beginner',
            'time_limit' => 30,
            'passing_score' => 60,
            'is_active' => true,
        ]);

        // 2. Add Essay Questions
        $questions = [
            [
                'text' => 'Ceritakan pengalaman atau alasan Anda belajar bahasa Jepang!',
                'ref' => 'Jawaban harus mengandung motivasi dan rencana studi.',
                'points' => 30
            ],
            [
                'text' => 'Apa perbedaan antara salam "Konnichiwa" dan "Konbanwa" serta kapan penggunaannya?',
                'ref' => 'Konnichiwa (siang), Konbanwa (malam).',
                'points' => 20
            ],
            [
                'text' => 'Sebutkan 3 jenis huruf dalam bahasa Jepang dan jelaskan fungsinya masing-masing!',
                'ref' => 'Hiragana (asli), Katakana (serapan), Kanji (ideogram).',
                'points' => 50
            ],
        ];

        foreach ($questions as $index => $q) {
            QuizQuestion::create([
                'quiz_id' => $essayQuiz->id,
                'question_text' => $q['text'],
                'question_type' => 'essay',
                'correct_answer' => $q['ref'],
                'points' => $q['points'],
                'order' => $index + 1,
            ]);
        }

        // 3. Create Student Data and Approved Transaction
        $siswa = User::firstOrCreate(
            ['email' => 'siswa.essai@example.com'],
            [
                'name' => 'Budi Essai',
                'password' => bcrypt('password'),
                'role' => 'member',
                'status' => 'active',
            ]
        );

        DB::table('transactions')->updateOrInsert(
            ['user_id' => $siswa->id, 'package_type' => 'Basic N5'],
            [
                'status' => 'approved',
                'payment_method' => 'bank_transfer',
                'amount' => 399000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 4. Create an Attempt that needs grading
        $answers = [
            1 => 'Saya belajar bahasa Jepang karena saya suka anime dan ingin bekerja di perusahaan Jepang.',
            2 => 'Konnichiwa dipakai saat siang hari sampai sore, sedangkan Konbanwa dipakai saat matahari sudah terbenam.',
            3 => 'Hiragana untuk kata asli Jepang, Katakana untuk kata asing, dan Kanji untuk mewakili makna kata.'
        ];

        UserQuizAttempt::create([
            'user_id' => $siswa->id,
            'quiz_id' => $essayQuiz->id,
            'score' => 0, // Not graded yet
            'max_score' => 100,
            'percentage' => 0,
            'time_taken' => 15,
            'answers' => $answers,
            'is_passed' => false,
            'status' => 'needs_grading', // Important for sensei dashboard
            'completed_at' => now(),
        ]);
    }
}
