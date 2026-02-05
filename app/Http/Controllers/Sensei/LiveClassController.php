<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LiveClassController extends Controller
{
    public function index()
    {
        // Mock summary data
        $summary = [
            'total_this_month' => 12,
            'today_count' => 1,
            'ongoing_count' => 1,
        ];

        // Mock sessions data
        $sessions = [
            [
                'id' => 1,
                'title' => 'Bunpou Practice: Conditional Forms',
                'topic' => 'Penggunaan Tara, Ba, dan Nara',
                'level' => 'N4',
                'platform' => 'Zoom',
                'students_count' => 15,
                'status' => 'live', // upcoming, live, completed
                'date' => 'Hari Ini',
                'time' => '19:00 - 21:00 WIB',
                'time_start' => '19:00',
            ],
            [
                'id' => 2,
                'title' => 'Basic Conversation: Daily Life',
                'topic' => 'Percakapan sehari-hari di supermarket',
                'level' => 'N5',
                'platform' => 'Zoom',
                'students_count' => 8,
                'status' => 'upcoming',
                'date' => 'Besok, 7 Jan',
                'time' => '15:00 - 17:00 WIB',
                'time_start' => '15:00',
            ],
            [
                'id' => 3,
                'title' => 'Kanji Mastery N3: Week 1',
                'topic' => 'Kanji terkait pekerjaan dan bisnis',
                'level' => 'N3',
                'platform' => 'Zoom',
                'students_count' => 20,
                'status' => 'completed',
                'date' => 'Kemarin, 5 Jan',
                'time' => '09:00 - 12:00 WIB',
                'time_start' => '09:00',
            ],
            [
                'id' => 4,
                'title' => 'Persiapan Tokutei Ginou: Food Service',
                'topic' => 'Kosakata spesifik industri makanan',
                'level' => 'TG',
                'platform' => 'Zoom',
                'students_count' => 12,
                'status' => 'upcoming',
                'date' => 'Jumat, 9 Jan',
                'time' => '13:00 - 15:00 WIB',
                'time_start' => '13:00',
            ],
        ];

        return view('sensei.live.index', compact('summary', 'sessions'));
    }
}
