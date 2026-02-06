<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class N5AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $modules = Module::whereHas('course', function($q) {
            $q->where('level', 'Basic N5');
        })->get();

        if ($modules->isEmpty()) {
            $this->command->warn('No N5 modules found. Skipping assignment seeder.');
            return;
        }

        $firstModule = $modules->first();

        $assignments = [
            [
                'title' => 'Latihan Menulis Hiragana',
                'description' => '<p>Tulis semua huruf Hiragana (あ-ん) secara manual di kertas. Upload foto hasil tulisan Anda.</p><p><strong>Penilaian:</strong></p><ul><li>Stroke order yang benar: 40 poin</li><li>Bentuk huruf rapi: 30 poin</li><li>Kelengkapan: 30 poin</li></ul>',
                'module_id' => $firstModule->id,
                'assignment_type' => 'writing',
                'max_score' => 100,
                'due_date' => now()->addDays(7),
                'is_required' => true,
            ],
            [
                'title' => 'Audio: Perkenalan Diri',
                'description' => '<p>Rekam audio perkenalan diri Anda dalam bahasa Jepang (minimal 1 menit).</p><p><strong>Harus mencakup:</strong></p><ul><li>Nama (お名前は何ですか)</li><li>Asal (どこから来ましたか)</li><li>Pekerjaan/status (お仕事は何ですか)</li><li>Hobi (趣味は何ですか)</li></ul>',
                'module_id' => $firstModule->id,
                'assignment_type' => 'speaking',
                'max_score' => 100,
                'due_date' => now()->addDays(10),
                'is_required' => true,
            ],
            [
                'title' => 'Menulis Kalimat Sederhana',
                'description' => '<p>Buat 10 kalimat menggunakan pola kalimat dasar (Subject + は + Noun/Adjective + です).</p><p><strong>Contoh:</strong> 私は学生です (Saya adalah pelajar)</p><p>Ketik langsung di form atau upload file dokumen.</p>',
                'module_id' => $firstModule->id,
                'assignment_type' => 'writing',
                'max_score' => 100,
                'due_date' => now()->addDays(14),
                'is_required' => false,
            ],
        ];

        foreach ($assignments as $data) {
            Assignment::create($data);
        }

        $this->command->info('✅ Successfully seeded ' . count($assignments) . ' N5 assignments!');
    }
}
