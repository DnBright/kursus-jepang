<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function index()
    {
        $pendingTransactions = Transaction::where('status', 'pending')
             ->with('user')
             ->orderBy('created_at', 'desc')
             ->get();

        $stats = [
            'pending_total' => $pendingTransactions->count(),
            'approved_today' => Transaction::where('status', 'approved')->whereDate('updated_at', today())->count(),
            'rejected_total' => Transaction::where('status', 'rejected')->count(),
            'avg_time' => '15 Menit'
        ];

        return view('admin.validations.index', compact('pendingTransactions', 'stats'));
    }
}
