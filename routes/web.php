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
    Route::get('/checkout/{package}', [App\Http\Controllers\CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{package}', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout'); // Keeping name 'checkout' for backward compatibility with form actions
    
    Route::get('/packages', [App\Http\Controllers\Member\PackageController::class, 'index'])->name('packages.index');
    
    Route::get('/payment/pending', function () {
        return view('member.packages.pending');
    })->name('payment.pending');
});


Route::middleware(['auth', 'member'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Member\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/packages', [App\Http\Controllers\Member\PackageController::class, 'index'])->name('packages.index');
    Route::get('/my-courses', [App\Http\Controllers\Member\CourseController::class, 'index'])->name('my-courses');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'member', 'package.active'])->group(function () {
    Route::get('/my-courses', [App\Http\Controllers\Member\CourseController::class, 'index'])->name('my-courses');

    Route::get('/courses/{id}', [App\Http\Controllers\Member\CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/lessons/{lesson}', [App\Http\Controllers\Member\LessonController::class, 'show'])->name('courses.lessons.show');

    Route::get('/live-class', [App\Http\Controllers\Member\LiveClassController::class, 'index'])->name('live-class');

    Route::get('/materials', [App\Http\Controllers\Member\MaterialController::class, 'index'])->name('materials.index');

    // Quiz Routes
    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::get('/', [App\Http\Controllers\Member\QuizController::class, 'index'])->name('index');
        Route::get('/{quiz}', [App\Http\Controllers\Member\QuizController::class, 'show'])->name('show');
        Route::post('/{quiz}/submit', [App\Http\Controllers\Member\QuizController::class, 'submit'])->name('submit');
        Route::get('/results/{attempt}', [App\Http\Controllers\Member\QuizController::class, 'results'])->name('results');
        Route::get('/{quiz}/leaderboard', [App\Http\Controllers\Member\QuizController::class, 'leaderboard'])->name('leaderboard');
    });

    Route::get('/certificates', [App\Http\Controllers\Member\CertificateController::class, 'index'])->name('certificates.index');

    
    // Assignment Routes
    Route::prefix('assignments')->name('assignments.')->group(function () {
        Route::get('/', [App\Http\Controllers\Member\AssignmentController::class, 'index'])->name('index');
        Route::get('/{assignment}', [App\Http\Controllers\Member\AssignmentController::class, 'show'])->name('show');
        Route::post('/{assignment}/submit', [App\Http\Controllers\Member\AssignmentController::class, 'submit'])->name('submit');
    });

    // Progress Tracking Routes
    Route::post('/lessons/{lesson}/complete', [App\Http\Controllers\Member\ProgressController::class, 'completeLesson'])->name('lessons.complete');
    Route::post('/lessons/{lesson}/notes', [App\Http\Controllers\Member\ProgressController::class, 'updateNotes'])->name('lessons.notes');
    Route::get('/progress/stats', [App\Http\Controllers\Member\ProgressController::class, 'stats'])->name('progress.stats');
});

// SENSEI ROUTES
Route::prefix('sensei')->name('sensei.')->group(function () {
    // Guest Sensei Routes (Login Only)
    Route::middleware('guest:sensei')->group(function () {
        Route::get('login', [App\Http\Controllers\Sensei\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [App\Http\Controllers\Sensei\Auth\AuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1');
    });

    // Authenticated Sensei Routes
    Route::middleware(['auth:sensei', 'sensei.approved'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Sensei\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/api/courses/{course}/modules', function (\App\Models\Course $course) {
            return $course->modules()->where('instructor_id', Auth::guard('sensei')->id())->get();
        })->name('api.course.modules');

        Route::get('/classes', [App\Http\Controllers\Sensei\ClassController::class, 'index'])->name('classes.index');
        Route::get('/live-class', [App\Http\Controllers\Sensei\LiveClassController::class, 'index'])->name('live.index');
        Route::get('/live-class/create', [App\Http\Controllers\Sensei\LiveClassController::class, 'create'])->name('live.create');
        Route::post('/live-class', [App\Http\Controllers\Sensei\LiveClassController::class, 'store'])->name('live.store');
        Route::get('/live-class/{live_class}/edit', [App\Http\Controllers\Sensei\LiveClassController::class, 'edit'])->name('live.edit');
        Route::put('/live-class/{live_class}', [App\Http\Controllers\Sensei\LiveClassController::class, 'update'])->name('live.update');
        Route::delete('/live-class/{live_class}', [App\Http\Controllers\Sensei\LiveClassController::class, 'destroy'])->name('live.destroy');
        Route::get('/materials', [App\Http\Controllers\Sensei\MaterialController::class, 'index'])->name('materials.index');
        Route::post('/materials/modules', [App\Http\Controllers\Sensei\MaterialController::class, 'storeModule'])->name('materials.modules.store');
        Route::delete('/materials/modules/{module}', [App\Http\Controllers\Sensei\MaterialController::class, 'destroyModule'])->name('materials.modules.destroy');
        
        Route::get('/materials/lessons/create', [App\Http\Controllers\Sensei\MaterialController::class, 'createLesson'])->name('materials.lessons.create');
        Route::post('/materials/lessons', [App\Http\Controllers\Sensei\MaterialController::class, 'storeLesson'])->name('materials.lessons.store');
        Route::get('/materials/lessons/{lesson}/edit', [App\Http\Controllers\Sensei\MaterialController::class, 'editLesson'])->name('materials.lessons.edit');
        Route::put('/materials/lessons/{lesson}', [App\Http\Controllers\Sensei\MaterialController::class, 'updateLesson'])->name('materials.lessons.update');
        Route::delete('/materials/lessons/{lesson}', [App\Http\Controllers\Sensei\MaterialController::class, 'destroyLesson'])->name('materials.lessons.destroy');
        Route::resource('/quizzes', App\Http\Controllers\Sensei\QuizController::class)->names([
            'index' => 'quizzes.index',
            'create' => 'quizzes.create',
            'store' => 'quizzes.store',
            'edit' => 'quizzes.edit',
            'update' => 'quizzes.update',
            'destroy' => 'quizzes.destroy',
        ]);
        Route::get('/quizzes/{quiz}/questions', [App\Http\Controllers\Sensei\QuizController::class, 'questions'])->name('quizzes.questions');
        Route::post('/quizzes/{quiz}/questions', [App\Http\Controllers\Sensei\QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
        Route::delete('/quizzes/{quiz}/questions/{question}', [App\Http\Controllers\Sensei\QuizController::class, 'destroyQuestion'])->name('quizzes.questions.destroy');

        // Quiz Grading Routes
        Route::get('/quizzes-grading', [App\Http\Controllers\Sensei\QuizController::class, 'gradingAttempts'])->name('quizzes.grading.index');
        Route::get('/quizzes-grading/{attempt}', [App\Http\Controllers\Sensei\QuizController::class, 'gradeAttempt'])->name('quizzes.grading.show');
        Route::post('/quizzes-grading/{attempt}', [App\Http\Controllers\Sensei\QuizController::class, 'submitAttemptGrade'])->name('quizzes.grading.store');

        Route::resource('/assignments', App\Http\Controllers\Sensei\AssignmentController::class)->names([
            'create' => 'assignments.create',
            'store' => 'assignments.store',
            'edit' => 'assignments.edit',
            'update' => 'assignments.update',
            'destroy' => 'assignments.destroy',
        ]);
        Route::get('/assignments/{assignment}/grading', [App\Http\Controllers\Sensei\AssignmentController::class, 'grading'])->name('assignments.grading');
        Route::post('/assignments/submissions/{submission}/grade', [App\Http\Controllers\Sensei\AssignmentController::class, 'submitGrade'])->name('assignments.submit-grade');
        Route::get('/students', [App\Http\Controllers\Sensei\StudentController::class, 'index'])->name('students.index');
        Route::resource('/schedule', App\Http\Controllers\Sensei\ScheduleController::class)->names([
            'index' => 'schedule.index',
            'create' => 'schedule.create',
            'store' => 'schedule.store',
            'edit' => 'schedule.edit',
            'update' => 'schedule.update',
            'destroy' => 'schedule.destroy',
        ]);
        
        Route::post('logout', [App\Http\Controllers\Sensei\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
        Route::get('logout', [App\Http\Controllers\Sensei\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout.get');
    });
});

// ADMIN ROUTES
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Guest Admin Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AdminAuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1');
    });

    // Authenticated Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout');
        Route::get('logout', [AdminAuthenticatedSessionController::class, 'destroy'])->name('logout.get');
        
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
        Route::get('/validations', [App\Http\Controllers\Admin\ValidationController::class, 'index'])->name('validations.index');
        Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/classes', [App\Http\Controllers\Admin\ClassController::class, 'index'])->name('classes.index');
        Route::get('/classes/create', [App\Http\Controllers\Admin\ClassController::class, 'create'])->name('classes.create');
        Route::post('/classes', [App\Http\Controllers\Admin\ClassController::class, 'store'])->name('classes.store');
        Route::get('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'index'])->name('materials.index');
        Route::get('/materials/create', [App\Http\Controllers\Admin\MaterialController::class, 'create'])->name('materials.create');
        Route::post('/materials', [App\Http\Controllers\Admin\MaterialController::class, 'store'])->name('materials.store');
        Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
        // Route::get('/payments/export', [App\Http\Controllers\Admin\PaymentController::class, 'export'])->name('payments.export');
        Route::post('/payments/{id}/approve', [App\Http\Controllers\Admin\PaymentController::class, 'approve'])->name('payments.approve');
        Route::post('/payments/{id}/reject', [App\Http\Controllers\Admin\PaymentController::class, 'reject'])->name('payments.reject');
        Route::get('/certificates', [App\Http\Controllers\Admin\CertificateController::class, 'index'])->name('certificates.index');
        // Route::post('/certificates/approve', [App\Http\Controllers\Admin\CertificateController::class, 'approve'])->name('certificates.approve');
        Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        // Route::get('/reports/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('reports.export');
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        
        Route::post('/users/{id}/approve', [App\Http\Controllers\Admin\UserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{id}/reject', [App\Http\Controllers\Admin\UserController::class, 'reject'])->name('users.reject');
        
        // Transaction approval routes
        Route::post('/transactions/{id}/approve', [App\Http\Controllers\AdminController::class, 'approve'])->name('approve');
        Route::post('/transactions/{id}/reject', [App\Http\Controllers\AdminController::class, 'reject'])->name('reject');

        Route::post('/accounts/{id}/approve', [App\Http\Controllers\AdminController::class, 'approveAccount'])->name('accounts.approve');
        Route::post('/accounts/{id}/reject', [App\Http\Controllers\AdminController::class, 'rejectAccount'])->name('accounts.reject');

        // Manual Sensei Management
        Route::resource('senseis', App\Http\Controllers\Admin\SenseiController::class);
    });
});

require __DIR__.'/auth.php';
