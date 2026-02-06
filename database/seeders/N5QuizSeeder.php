<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Course;
use Illuminate\Database\Seeder;

class N5QuizSeeder extends Seeder
{
    public function run(): void
    {
        $n5Course = Course::where('level', 'Basic N5')->first();

        if (!$n5Course) {
            $this->command->warn('Course "Basic N5" not found. Skipping quiz seeder.');
            return;
        }

        // Quiz 1: Hiragana Recognition (Daily Quiz)
        $hiraganaQuiz = Quiz::create([
            'title' => 'Daily Quiz: Hiragana あ-さ',
            'description' => 'Latihan mengenali huruf Hiragana dari A sampai SA. Perfect untuk pemula!',
            'type' => 'daily',
            'difficulty' => 'beginner',
            'time_limit' => 10,
            'passing_score' => 70,
            'is_active' => true,
        ]);

        $hiraganaQuestions = [
            ['question_text' => 'Bagaimana cara membaca huruf ini: あ', 'answer' => 'A', 'options' => ['A' => 'a', 'B' => 'i', 'C' => 'u', 'D' => 'e']],
            ['question_text' => 'Bagaimana cara membaca: か', 'answer' => 'B', 'options' => ['A' => 'sa', 'B' => 'ka', 'C' => 'ta', 'D' => 'na']],
            ['question_text' => 'Pilih huruf Hiragana yang benar untuk "shi"', 'answer' => 'C', 'options' => ['A' => 'せ', 'B' => 'そ', 'C' => 'し', 'D' => 'す']],
            ['question_text' => 'Apa bacaan dari: さ', 'answer' => 'D', 'options' => ['A' => 'ka', 'B' => 'ta', 'C' => 'na', 'D' => 'sa']],
            ['question_text' => 'Huruf Hiragana untuk "ko" adalah?', 'answer' => 'A', 'options' => ['A' => 'こ', 'B' => 'く', 'C' => 'け', 'D' => 'き']],
            ['question_text' => 'Baca hiragana ini: きつね means fox. Bagaimana bacaannya?', 'answer' => 'kitsune', 'type' => 'fill_blank'],
            ['question_text' => 'さくら (sakura) artinya cherry blossom', 'answer' => 'true', 'type' => 'true_false'],
            ['question_text' => 'Bagaimana cara menulis "te" dalam Hiragana?', 'answer' => 'B', 'options' => ['A' => 'た', 'B' => 'て', 'C' => 'と', 'D' => 'つ']],
            ['question_text' => 'Huruf お dibaca sebagai "o"', 'answer' => 'true', 'type' => 'true_false'],
            ['question_text' => 'Pilih Hiragana yang salah: A) あいうえお (all vowels)', 'answer' => 'true', 'type' => 'true_false'],
        ];

        foreach ($hiraganaQuestions as $index => $q) {
            QuizQuestion::create([
                'quiz_id' => $hiraganaQuiz->id,
                'question_text' => $q['question_text'],
                'question_type' => $q['type'] ?? 'multiple_choice',
                'options' => $q['options'] ?? null,
                'correct_answer' => $q['answer'],
                'explanation' => 'Review Hiragana chart untuk menguasai huruf dasar.',
                'points' => 10,
                'order' => $index + 1,
            ]);
        }

        // Quiz 2: Katakana Recognition (Daily Quiz)
        $katakanaQuiz = Quiz::create([
            'title' => 'Daily Quiz: Katakana ア-サ',
            'description' => 'Test pengenalan Katakana untuk kata serapan asing.',
            'type' => 'daily',
            'difficulty' => 'beginner',
            'time_limit' => 10,
            'passing_score' => 70,
            'is_active' => true,
        ]);

        $katakanaQuestions = [
            ['question_text' => 'Katakana untuk "a" adalah?', 'answer' => 'A', 'options' => ['A' => 'ア', 'B' => 'イ', 'C' => 'ウ', 'D' => 'エ']],
            ['question_text' => 'Baca kata ini: コーヒー', 'answer' => 'koohii', 'type' => 'fill_blank'],
            ['question_text' => 'Katakana digunakan untuk kata-kata serapan asing', 'answer' => 'true', 'type' => 'true_false'],
            ['question_text' => 'Bagaimana menulis "ka" dalam Katakana?', 'answer' => 'B', 'options' => ['A' => 'サ', 'B' => 'カ', 'C' => 'タ', 'D' => 'ナ']],
            ['question_text' => 'アメリカ berarti Amerika/America', 'answer' => 'true', 'type' => 'true_false'],
        ];

        foreach ($katakanaQuestions as $index => $q) {
            QuizQuestion::create([
                'quiz_id' => $katakanaQuiz->id,
                'question_text' => $q['question_text'],
                'question_type' => $q['type'] ?? 'multiple_choice',
                'options' => $q['options'] ?? null,
                'correct_answer' => $q['answer'],
                'explanation' => 'Katakana digunakan untuk kata-kata asing, nama tempat, dan sound effects.',
                'points' => 10,
                'order' => $index + 1,
            ]);
        }

        // Quiz 3: Basic Vocabulary (Weekly Quiz)
        $vocabQuiz = Quiz::create([
            'title' => 'Week 1: Basic Greetings & Numbers',
            'description' => 'Menguji pemahaman salam dasar dan angka 1-10 dalam bahasa Jepang.',
            'type' => 'weekly',
            'difficulty' => 'beginner',
            'time_limit' => 15,
            'passing_score' => 75,
            'is_active' => true,
        ]);

        $vocabQuestions = [
            ['question_text' => 'Apa arti dari おはよう (ohayou)?', 'answer' => 'A', 'options' => ['A' => 'Selamat pagi', 'B' => 'Selamat malam', 'C' => 'Terima kasih', 'D' => 'Maaf']],
            ['question_text' => 'Bagaimana mengatakan "Terima kasih" dalam bahasa Jepang?', 'answer' => 'arigatou', 'type' => 'fill_blank'],
            ['question_text' => 'こんにちは digunakan untuk salam siang hari', 'answer' => 'true', 'type' => 'true_false'],
            ['question_text' => 'Angka "3" dalam bahasa Jepang adalah?', 'answer' => 'B', 'options' => ['A' => 'ni', 'B' => 'san', 'C' => 'yon', 'D' => 'go']],
            ['question_text' => 'さようなら (sayounara) berarti "selamat tinggal/goodbye"', 'answer' => 'true', 'type' => 'true_false'],
            ['question_text' => 'Apa ucapan yang tepat sebelum makan?', 'answer' => 'C', 'options' => ['A' => 'Tadaima', 'B' => 'Gochisousama', 'C' => 'Itadakimasu', 'D' => 'Ittekimasu']],
            ['question_text' => '"Maaf" dalam bahasa Jepang formal adalah?', 'answer' => 'sumimasen', 'type' => 'fill_blank'],
            ['question_text' => 'Angka "10" dibaca sebagai "juu"', 'answer' => 'true', 'type' => 'true_false'],
            ['question_text' => 'Ucapan saat pulang ke rumah adalah?', 'answer' => 'D', 'options' => ['A' => 'Ittekimasu', 'B' => 'Itterashai', 'C' => 'Okaeri', 'D' => 'Tadaima']],
            ['question_text' => 'おやすみなさい (oyasuminasai) digunakan untuk mengucapkan selamat tidur', 'answer' => 'true', 'type' => 'true_false'],
        ];

        foreach ($vocabQuestions as $index => $q) {
            QuizQuestion::create([
                'quiz_id' => $vocabQuiz->id,
                'question_text' => $q['question_text'],
                'question_type' => $q['type'] ?? 'multiple_choice',
                'options' => $q['options'] ?? null,
                'correct_answer' => $q['answer'],
                'explanation' => 'Salam dan angka adalah fondasi penting dalam percakapan sehari-hari.',
                'points' => 10,
                'order' => $index + 1,
            ]);
        }

        // Quiz 4: Basic Grammar (Module Test)
        $grammarQuiz = Quiz::create([
            'title' => 'Module Test: Particles は・を・が',
            'description' => 'Tes pemahaman partikel dasar dalam kalimat bahasa Jepang.',
            'type' => 'module_test',
            'difficulty' => 'intermediate',
            'time_limit' => 20,
            'passing_score' => 80,
            'is_active' => true,
        ]);

        $grammarQuestions = [
            ['question_text' => 'Lengkapi: 私___学生です (Saya adalah pelajar)', 'answer' => 'B', 'options' => ['A' => 'を', 'B' => 'は', 'C' => 'が', 'D' => 'に']],
            ['question_text' => 'Partikel を (wo) digunakan untuk menandai objek langsung', 'answer' => 'true', 'type' => 'true_false'],
            ['question_text' => 'Pilih partikel yang benar: りんご___食べます (Makan apel)', 'answer' => 'A', 'options' => ['A' => 'を', 'B' => 'は', 'C' => 'が', 'D' => 'で']],
            ['question_text' => 'Dalam kalimat "猫がいます", partikel が menunjukkan subjek yang baru atau fokus perhatian', 'answer' => 'true', 'type' => 'true_false'],
            ['question_text' => 'Partikel は (wa) digunakan untuk topik kalimat', 'answer' => 'true', 'type' => 'true_false'],
        ];

        foreach ($grammarQuestions as $index => $q) {
            QuizQuestion::create([
                'quiz_id' => $grammarQuiz->id,
                'question_text' => $q['question_text'],
                'question_type' => $q['type'] ?? 'multiple_choice',
                'options' => $q['options'] ?? null,
                'correct_answer' => $q['answer'],
                'explanation' => 'Partikel adalah elemen krusial yang menentukan fungsi kata dalam kalimat.',
                'points' => 20,
                'order' => $index + 1,
            ]);
        }

        // Quiz 5: Mini Mock JLPT N5
        $mockJlptQuiz = Quiz::create([
            'title' => 'Mini Mock Test: JLPT N5 Simulation',
            'description' => 'Simulasi mini tes JLPT N5 - 15 soal pilihan dari berbagai topik.',
            'type' => 'mock_jlpt',
            'difficulty' => 'intermediate',
            'time_limit' => 30,
            'passing_score' => 75,
            'is_active' => true,
        ]);

        $mockQuestions = [
            // Vocab
            ['question_text' => '「本」の読み方は何ですか？', 'answer' => 'C', 'options' => ['A' => 'ぼん', 'B' => 'ぽん', 'C' => 'ほん', 'D' => 'もん']],
            ['question_text' => '「学校」の意味は？', 'answer' => 'A', 'options' => ['A' => 'School', 'B' => 'House', 'C' => 'Station', 'D' => 'Park']],
            // Grammar
            ['question_text' => '私は毎日日本語___勉強します。', 'answer' => 'を', 'type' => 'fill_blank'],
            ['question_text' => '田中さん___先生です。', 'answer' => 'B', 'options' => ['A' => 'を', 'B' => 'は', 'C' => 'が', 'D' => 'も']],
            ['question_text' => 'これ___ペンです。', 'answer' => 'は', 'type' => 'fill_blank'],
            // Reading
            ['question_text' => '「コーヒーを飲みます」の意味は？', 'answer' => 'A', 'options' => ['A' => 'Minum kopi', 'B' => 'Beli kopi', 'C' => 'Buat kopi', 'D' => 'Suka kopi']],
            ['question_text' => '「毎日」はどう読みますか？', 'answer' => 'C', 'options' => ['A' => 'まいつき', 'B' => 'まいしゅう', 'C' => 'まいにち', 'D' => 'まいとし']],
            // More vocab
            ['question_text' => '「食べる」は "to eat" という意味です', 'answer' => 'true', 'type' => 'true_false'],
            ['question_text' => '朝ごはんを___。', 'answer' => 'D', 'options' => ['A' => '見ます', 'B' => '聞きます', 'C' => '書きます', 'D' => '食べます']],
            ['question_text' => '「行きます」の辞書形は「行く」です', 'answer' => 'true', 'type' => 'true_false'],
        ];

        foreach ($mockQuestions as $index => $q) {
            QuizQuestion::create([
                'quiz_id' => $mockJlptQuiz->id,
                'question_text' => $q['question_text'],
                'question_type' => $q['type'] ?? 'multiple_choice',
                'options' => $q['options'] ?? null,
                'correct_answer' => $q['answer'],
                'explanation' => 'Review materi N5 untuk persiapan lebih baik.',
                'points' => 10,
                'order' => $index + 1,
            ]);
        }

        $this->command->info('✅ Successfully seeded 5 N5 quizzes with total ' . QuizQuestion::count() . ' questions!');
    }
}
