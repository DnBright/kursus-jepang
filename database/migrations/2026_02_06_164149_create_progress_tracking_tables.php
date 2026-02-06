<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Lesson progress table
        Schema::create('lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->integer('time_spent')->default(0)->comment('in seconds');
            $table->integer('video_progress')->default(0)->comment('seconds watched');
            $table->dateTime('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'lesson_id']);
        });

        // User achievements table
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('achievement_type', ['badge', 'milestone'])->default('badge');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable()->comment('Path to badge image');
            $table->dateTime('earned_at');
            $table->timestamps();

            $table->index('user_id');
        });

        // User points table
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('points');
            $table->string('reason')->comment('quiz_completion, assignment_submission, daily_login, etc');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('reference_type')->nullable()->comment('Quiz, Assignment, Lesson, etc');
            $table->dateTime('earned_at');
            $table->timestamps();

            $table->index('user_id');
            $table->index(['reference_type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_points');
        Schema::dropIfExists('user_achievements');
        Schema::dropIfExists('lesson_progress');
    }
};
