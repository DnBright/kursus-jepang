<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL doesn't support changing enum values easily via Blueprint in older Laravel versions, 
        // so we use raw SQL to add 'essay' to the enum
        DB::statement("ALTER TABLE quiz_questions MODIFY COLUMN question_type ENUM('multiple_choice', 'true_false', 'fill_blank', 'matching', 'essay') DEFAULT 'multiple_choice'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE quiz_questions MODIFY COLUMN question_type ENUM('multiple_choice', 'true_false', 'fill_blank', 'matching') DEFAULT 'multiple_choice'");
    }
};
