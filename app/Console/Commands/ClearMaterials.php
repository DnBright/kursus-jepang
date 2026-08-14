<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearMaterials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-materials';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghapus isi database khusus untuk Kuis, Materi (Lesson), Module, dan Roadmap (TIDAK menyentuh Artikel atau Penulis).';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn('Perhatian: Perintah ini akan menghapus semua Kuis, Pertanyaan Kuis, Modul, Materi, dan langkah Roadmap secara PERMANEN.');
        
        if ($this->confirm('Apakah Anda yakin ingin melanjutkan?')) {
            $this->info('Memulai penghapusan data...');

            Schema::disableForeignKeyConstraints();

            // Kuis dan terkait
            DB::table('quiz_questions')->truncate();
            $this->line('- Tabel quiz_questions dibersihkan');
            
            DB::table('user_quiz_attempts')->truncate();
            $this->line('- Tabel user_quiz_attempts dibersihkan');
            
            DB::table('quizzes')->truncate();
            $this->line('- Tabel quizzes dibersihkan');

            // Roadmap
            DB::table('course_roadmap_steps')->truncate();
            $this->line('- Tabel course_roadmap_steps dibersihkan');

            // Modul dan Materi
            DB::table('lesson_progress')->truncate();
            $this->line('- Tabel lesson_progress dibersihkan');
            
            DB::table('lessons')->truncate();
            $this->line('- Tabel lessons dibersihkan');
            
            DB::table('modules')->truncate();
            $this->line('- Tabel modules dibersihkan');

            Schema::enableForeignKeyConstraints();

            $this->info('Selesai! Database untuk kuis, materi, modul, dan roadmap telah dikosongkan.');
        } else {
            $this->info('Dibatalkan. Database tidak disentuh.');
        }
    }
}
