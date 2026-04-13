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
        // Real data for Students
        $students = User::whereIn('role', ['user', 'member', 'student'])
             ->orderBy('created_at', 'desc')
             ->get();

        // Real data for Senseis
        $senseis = Sensei::orderBy('created_at', 'desc')
            ->get();
        
        $stats = [
            'total_active' => $students->where('status', 'active')->count() + $senseis->where('status', 'active')->count(),
            'total_students' => $students->count(),
            'total_sensei' => $senseis->count(),
            'total_inactive' => $students->where('status', '!=', 'active')->count() + $senseis->where('status', '!=', 'active')->count()
        ];

        return view('admin.users.index', compact('students', 'senseis', 'stats'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);

        return back()->with('success', 'User ' . $user->name . ' berhasil diaktifkan.');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        return back()->with('success', 'User ' . $user->name . ' telah ditolak.');
    }
}
