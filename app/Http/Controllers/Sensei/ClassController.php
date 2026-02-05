<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        // Mock data for design purposes
        $classes = [
            [
                'id' => 1,
                'name' => 'Intensive N4: Bunpou & Dokkai',
                'level' => 'N4',
                'status' => 'active',
                'students_count' => 12,
                'schedule_day' => 'Senin & Rabu',
                'schedule_time' => '19:00 - 21:00 WIB',
                'platform' => 'Zoom',
                'is_today' => true,
                'next_session' => 'Hari Ini, 19:00',
            ],
            [
                'id' => 2,
                'name' => 'Basic Conversation: Daily Life',
                'level' => 'N5',
                'status' => 'active',
                'students_count' => 8,
                'schedule_day' => 'Selasa & Kamis',
                'schedule_time' => '15:00 - 17:00 WIB',
                'platform' => 'Zoom',
                'is_today' => false,
                'next_session' => 'Besok, 15:00',
            ],
            [
                'id' => 3,
                'name' => 'Kanji Mastery N3',
                'level' => 'N3',
                'status' => 'finished',
                'students_count' => 20,
                'schedule_day' => 'Sabtu',
                'schedule_time' => '09:00 - 12:00 WIB',
                'platform' => 'LMS',
                'is_today' => false,
                'next_session' => '-',
            ],
             [
                'id' => 4,
                'name' => 'Persiapan Tokutei Ginou',
                'level' => 'TG',
                'status' => 'active',
                'students_count' => 15,
                'schedule_day' => 'Jumat',
                'schedule_time' => '13:00 - 15:00 WIB',
                'platform' => 'Zoom',
                'is_today' => false,
                'next_session' => 'Jumat Depan',
            ],
        ];

        return view('sensei.classes.index', compact('classes'));
    }
}
