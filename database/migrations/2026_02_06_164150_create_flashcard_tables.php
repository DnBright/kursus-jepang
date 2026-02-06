<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Flashcards table
        Schema::create('flashcards', function (Blueprint $table) {
            $table->id();
            $table->string('deck_name')->comment('e.g., N5 Vocabulary Week 1');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->enum('card_type', ['vocab', 'kanji', 'grammar'])->default('vocab');
            $table->text('front')->comment('Question/Japanese word');
            $table->text('back')->comment('Answer/Translation');
            $table->text('hint')->nullable();
            $table->text('example_sentence')->nullable();
            $table->string('audio_url')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('difficulty_level')->default(1)->comment('1-5 scale');
            $table->timestamps();

            $table->index(['course_id', 'deck_name']);
        });

        // User flashcard reviews table (SRS algorithm data)
        Schema::create('user_flashcard_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('flashcard_id')->constrained()->onDelete('cascade');
            $table->decimal('ease_factor', 3, 2)->default(2.50)->comment('SRS ease factor');
            $table->integer('interval')->default(0)->comment('Days until next review');
            $table->integer('repetitions')->default(0);
            $table->dateTime('next_review_at')->nullable();
            $table->dateTime('last_reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'flashcard_id']);
            $table->index(['user_id', 'next_review_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_flashcard_reviews');
        Schema::dropIfExists('flashcards');
    }
};
