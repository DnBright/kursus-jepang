<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Schema::disableForeignKeyConstraints();

// Clear Quizzes and related
DB::table('quiz_questions')->truncate();
DB::table('user_quiz_attempts')->truncate();
DB::table('quizzes')->truncate();

// Clear Roadmap
DB::table('course_roadmap_steps')->truncate();

// Clear Materials (Lessons) and Modules
DB::table('lesson_progress')->truncate();
DB::table('lessons')->truncate();
DB::table('modules')->truncate();

// Should we clear courses? The user said "quiz atau materi". 
// Let's NOT clear courses so the N5, N4 programs remain.
// DB::table('courses')->truncate();

Schema::enableForeignKeyConstraints();

echo "Successfully cleared quizzes, roadmap steps, lessons, and modules.\n";
