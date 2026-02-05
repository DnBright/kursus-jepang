<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sensei;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Mock data for Students
        $students = User::where('role', 'member')
             ->orWhere('role', 'student') 
             ->orderBy('created_at', 'desc')
             ->get();

        if($students->isEmpty()) {
            $students = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Budi Santoso',
                    'email' => 'budi@example.com',
                    'selected_package' => 'N5 Intensive A',
                    'status' => 'active',
                    'created_at' => now()->subMonths(1),
                    'progress' => 45
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Siti Aminah',
                    'email' => 'siti@example.com',
                    'selected_package' => 'N4 Regular B',
                    'status' => 'suspended',
                    'created_at' => now()->subMonths(2),
                    'progress' => 70
                ]
            ]);
        }

        // Mock data for Senseis
        $senseis = Sensei::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        if($senseis->isEmpty()) {
            $senseis = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Tanaka Ken',
                    'email' => 'tanaka@sensei.com',
                    'teaching_field' => 'N5, N4',
                    'class_count' => 3,
                    'status' => 'active',
                    'created_at' => now()->subYear()
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Sato Yuki',
                    'email' => 'sato@sensei.com',
                    'teaching_field' => 'Tokutei Ginou',
                    'class_count' => 1,
                    'status' => 'inactive',
                    'created_at' => now()->subMonth()
                ]
            ]);
        }
        
        $stats = [
            'total_active' => $students->where('status', 'active')->count() + $senseis->where('status', 'active')->count(),
            'total_students' => $students->count(),
            'total_sensei' => $senseis->count(),
            'total_inactive' => $students->where('status', '!=', 'active')->count() + $senseis->where('status', '!=', 'active')->count()
        ];

        return view('admin.users.index', compact('students', 'senseis', 'stats'));
    }
}
