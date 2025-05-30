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
        Schema::table('issues', function (Blueprint $table) {
            // Change severity, occurrence, and detection to string
            $table->string('severity')->change();
            $table->string('occurrence')->change();
            $table->string('detection')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            // Revert severity, occurrence, and detection back to integer
            $table->integer('severity')->change();
            $table->integer('occurrence')->change();
            $table->integer('detection')->change();
        });
    }
};
