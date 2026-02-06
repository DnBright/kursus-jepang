<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Quizzes table
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('type', ['daily', 'weekly', 'module_test', 'mock_jlpt'])->default('daily');
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->integer('time_limit')->nullable()->comment('in minutes');
            $table->integer('passing_score')->default(70)->comment('percentage');
            $table->boolean('is_active')->default(true);
            $table->dateTime('available_from')->nullable();
            $table->dateTime('available_until')->nullable();
            $table->timestamps();
        });

        // Quiz questions table
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->enum('question_type', ['multiple_choice', 'true_false', 'fill_blank', 'matching'])->default('multiple_choice');
            $table->json('options')->nullable()->comment('For multiple choice questions');
            $table->string('correct_answer');
            $table->text('explanation')->nullable()->comment('Shown after answer');
            $table->integer('points')->default(1);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // User quiz attempts table
        Schema::create('user_quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->integer('score')->default(0)->comment('Points earned');
            $table->integer('max_score')->comment('Total possible points');
            $table->decimal('percentage', 5, 2)->default(0);
            $table->integer('time_taken')->nullable()->comment('in seconds');
            $table->json('answers')->nullable()->comment('User answers');
            $table->boolean('is_passed')->default(false);
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'quiz_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_quiz_attempts');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
    }
};
