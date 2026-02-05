<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        // Mock data for Today's Agenda
        $today_agenda = [
            [
                'id' => 1,
                'title' => 'Live Class: Tata Bahasa N5',
                'class' => 'N5 Intensive A',
                'time_start' => '10:00',
                'time_end' => '11:30',
                'type' => 'live_class',
                'status' => 'upcoming', // upcoming, ongoing, completed
                'platform' => 'Zoom',
            ],
             [
                'id' => 2,
                'title' => 'Sesi Konsultasi Siswa',
                'class' => 'Siti Aminah',
                'time_start' => '14:00',
                'time_end' => '14:30',
                'type' => 'consultation',
                'status' => 'upcoming',
                'platform' => 'Google Meet',
            ],
        ];

        // Mock data for Upcoming/Weekly Schedule (simplified for grid)
        // In a real app, this would be structured by date/time
        $weekly_schedule = [
            'Senin' => [
                [
                    'title' => 'N5 Intensive A',
                    'time' => '10:00 - 11:30',
                    'type' => 'live_class',
                    'level' => 'N5'
                ],
                [
                    'title' => 'Konsultasi: Budi',
                    'time' => '14:00 - 14:30',
                    'type' => 'consultation',
                    'level' => 'N5'
                ]
            ],
            'Selasa' => [
                 [
                    'title' => 'TG Food Service',
                    'time' => '19:00 - 21:00',
                    'type' => 'live_class',
                    'level' => 'TG'
                ]
            ],
            'Rabu' => [],
            'Kamis' => [
                 [
                    'title' => 'N4 Regular B',
                    'time' => '16:00 - 17:30',
                    'type' => 'live_class',
                    'level' => 'N4'
                ]
            ],
            'Jumat' => [
                 [
                    'title' => 'Evaluasi Mingguan',
                    'time' => '09:00 - 10:00',
                    'type' => 'exam',
                    'level' => 'All'
                ]
            ],
            'Sabtu' => [],
            'Minggu' => []
        ];

        return view('sensei.schedule.index', compact('today_agenda', 'weekly_schedule'));
    }
}
