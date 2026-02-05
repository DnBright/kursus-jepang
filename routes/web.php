<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminAuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/verification/notice', function () {
    return view('auth.pending');
})->name('verification.notice');

// USER ROUTES
Route::middleware(['auth'])->group(function () {
    Route::post('/checkout/{package}', function ($package) {
        request()->user()->update([
            'payment_status' => 'pending',
            'selected_package' => $package
        ]);
        return back()->with('status', 'Permintaan pembelian paket ' . $package . ' berhasil dikirim. Silakan tunggu konfirmasi Admin.');
    })->name('checkout');
});

Route::middleware(['auth', 'member'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/my-courses', function () {
        return view('member.courses.index');
    })->name('my-courses');

    Route::get('/courses/{id}', [App\Http\Controllers\Member\CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/lessons/{lesson}', [App\Http\Controllers\Member\LessonController::class, 'show'])->name('courses.lessons.show');

    Route::get('/live-class', function () {
        return view('member.live.index');
    })->name('live-class');

    Route::get('/materials', function () {
        return view('member.materials.index');
    })->name('materials.index');

    Route::get('/quizzes', function () {
        return view('member.quizzes.index');
    })->name('quizzes.index');

    Route::get('/certificates', function () {
        return view('member.certificates.index');
    })->name('certificates.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// SENSEI ROUTES
Route::prefix('sensei')->name('sensei.')->group(function () {
    // Guest Sensei Routes (Login Only)
    Route::middleware('guest:sensei')->group(function () {
        Route::get('login', [App\Http\Controllers\Sensei\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [App\Http\Controllers\Sensei\Auth\AuthenticatedSessionController::class, 'store']);
    });

    // Authenticated Sensei Routes
    Route::middleware(['auth:sensei'])->group(function () {
        Route::get('/dashboard', function () {
            return view('sensei.dashboard');
        })->name('dashboard');

        Route::get('/classes', [App\Http\Controllers\Sensei\ClassController::class, 'index'])->name('classes.index');
        Route::get('/live-class', [App\Http\Controllers\Sensei\LiveClassController::class, 'index'])->name('live.index');
        Route::get('/materials', [App\Http\Controllers\Sensei\MaterialController::class, 'index'])->name('materials.index');
        Route::get('/quizzes', [App\Http\Controllers\Sensei\QuizController::class, 'index'])->name('quizzes.index');
        Route::get('/students', [App\Http\Controllers\Sensei\StudentController::class, 'index'])->name('students.index');
        Route::get('/schedule', [App\Http\Controllers\Sensei\ScheduleController::class, 'index'])->name('schedule.index');
        
        Route::post('logout', [App\Http\Controllers\Sensei\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});

// ADMIN ROUTES
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Guest Admin Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AdminAuthenticatedSessionController::class, 'store']);
    });

    // Authenticated Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
        
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
        Route::get('/validations', [App\Http\Controllers\Admin\ValidationController::class, 'index'])->name('validations.index');
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/classes', [App\Http\Controllers\Admin\ClassController::class, 'index'])->name('classes.index');
        Route::get('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'index'])->name('materials.index');
        Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/certificates', [App\Http\Controllers\Admin\CertificateController::class, 'index'])->name('certificates.index');
        Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        
        Route::post('/users/{id}/approve', [App\Http\Controllers\AdminController::class, 'approve'])->name('users.approve');
        Route::post('/users/{id}/reject', [App\Http\Controllers\AdminController::class, 'reject'])->name('users.reject');

        // Manual Sensei Management
        Route::resource('senseis', App\Http\Controllers\Admin\SenseiController::class);
    });
});

require __DIR__.'/auth.php';
