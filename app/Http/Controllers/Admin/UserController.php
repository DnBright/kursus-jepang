<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sensei;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Real data for Students
        $students = User::whereIn('role', ['user', 'member', 'student'])
             ->orderBy('created_at', 'desc')
             ->get();
        
        $stats = [
            'total_active' => $students->where('status', 'active')->count(),
            'total_students' => $students->count(),
            'total_inactive' => $students->where('status', '!=', 'active')->count()
        ];

        return view('admin.users.index', compact('students', 'stats'));
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

    public function suspend($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'suspended']);

        return back()->with('success', 'User ' . $user->name . ' telah di-suspend.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'selected_package' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:active,pending,suspended'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'selected_package' => $request->selected_package,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Data siswa ' . $user->name . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        return back()->with('success', 'Akun siswa ' . $name . ' berhasil dihapus.');
    }
}
