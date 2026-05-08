<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Article;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Tips Cepat Menghafal Hiragana & Katakana dalam 1 Minggu',
                'excerpt' => 'Kuasai dasar penulisan bahasa Jepang dengan teknik memori visual yang efektif dan menyenangkan.',
                'content' => "Menghafal Hiragana dan Katakana adalah langkah pertama yang paling krusial dalam belajar Bahasa Jepang. Banyak pemula merasa kesulitan karena bentuknya yang asing.\n\nBerikut adalah beberapa tips untuk menguasainya dalam waktu singkat:\n1. Gunakan Flashcards: Metode klasik yang tetap paling efektif.\n2. Teknik Mnemonik: Hubungkan bentuk huruf dengan objek yang Anda kenal. Misal, huruf 'A' (あ) yang terlihat seperti antena.\n3. Berlatih Menulis Setiap Hari: Jangan hanya membaca, tapi tuliskan berulang kali.\n4. Gunakan Aplikasi Interaktif: Banyak aplikasi gratis yang membuat belajar terasa seperti bermain game.\n\nDengan konsistensi 30 menit setiap hari, Anda pasti bisa menguasai 46 huruf dasar ini dalam waktu kurang dari seminggu!",
                'is_published' => true,
            ],
            [
                'title' => '5 Peluang Karir Menarik di Jepang untuk Tenaga Kerja Indonesia',
                'excerpt' => 'Jepang sedang membuka pintu lebar bagi tenaga kerja asing. Cek bidang apa saja yang paling diminati saat ini.',
                'content' => "Jepang mengalami fenomena penuaan populasi yang membuat mereka sangat membutuhkan tenaga kerja muda dari luar negeri, termasuk Indonesia.\n\nBerikut 5 bidang utama yang sedang naik daun:\n1. Caregiver (Perawat Lansia): Kebutuhan tertinggi saat ini dengan fasilitas yang sangat baik.\n2. Engineering & IT: Jepang sangat menghargai talenta teknologi dari Asia Tenggara.\n3. Perhotelan & Pariwisata: Seiring dengan meningkatnya turis ke Jepang, kebutuhan staf multibahasa meningkat.\n4. Manufaktur: Industri otomotif dan elektronik tetap menjadi tulang punggung ekonomi Jepang.\n5. Pertanian Modern: Penggunaan teknologi dalam pertanian membutuhkan tenaga muda yang inovatif.\n\nPersiapan utama tentu saja adalah kemampuan bahasa (minimal JLPT N4) dan sertifikasi keahlian khusus (SSW).",
                'is_published' => true,
            ],
            [
                'title' => 'Mengenal Konsep "Omotenashi": Rahasia Pelayanan Terbaik Dunia',
                'excerpt' => 'Mengapa pelayanan di Jepang dianggap sebagai yang terbaik? Mari mengenal filosofi keramahan di balik setiap senyuman.',
                'content' => "Pernahkah Anda bertanya-tanya mengapa masuk ke toko di Jepang terasa begitu spesial? Rahasianya adalah 'Omotenashi'.\n\nSecara harfiah, Omotenashi berarti pelayanan dengan sepenuh hati tanpa mengharapkan imbalan. Ini bukan sekadar keramahan biasa, melainkan kemampuan untuk mengantisipasi kebutuhan tamu sebelum mereka memintanya.\n\nFilosofi ini sangat penting untuk dipahami jika Anda berencana tinggal atau bekerja di Jepang. Memahami Omotenashi akan membantu Anda beradaptasi dengan budaya kerja dan cara berinteraksi dengan orang Jepang secara lebih mendalam.",
                'is_published' => true,
            ],
        ];

        foreach ($articles as $article) {
            $article['slug'] = Str::slug($article['title']);
            Article::updateOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }
    }
}
