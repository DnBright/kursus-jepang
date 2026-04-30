<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_quiz_attempts', function (Blueprint $table) {
            $table->enum('status', ['completed', 'needs_grading'])->default('completed')->after('is_passed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_quiz_attempts', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
