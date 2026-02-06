<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Assignments table
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('module_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('assignment_type', ['writing', 'speaking', 'reading', 'listening', 'project'])->default('writing');
            $table->integer('max_score')->default(100);
            $table->dateTime('due_date')->nullable();
            $table->boolean('is_required')->default(true);
            $table->json('file_attachments')->nullable()->comment('Instructor uploaded files');
            $table->timestamps();
        });

        // Assignment submissions table
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content')->nullable()->comment('Written answer');
            $table->string('file_path')->nullable()->comment('Uploaded file (audio/video/document)');
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('graded_at')->nullable();
            $table->integer('score')->nullable();
            $table->text('feedback')->nullable();
            $table->enum('status', ['pending', 'graded', 'returned'])->default('pending');
            $table->timestamps();

            $table->unique(['assignment_id', 'user_id'], 'unique_user_assignment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('assignments');
    }
};
