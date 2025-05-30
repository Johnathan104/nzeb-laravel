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
        Schema::table('pemeliharaan', function (Blueprint $table) {
            // Make issue_id nullable and default to null
            $table->unsignedBigInteger('issue_id')->nullable()->default(null)->change();

            // Make part_type_id nullable
            $table->unsignedBigInteger('part_type_id')->nullable()->change();

            // Make room_id nullable
            $table->unsignedBigInteger('room_id')->nullable()->change();

            // Add status column with enum values
            $table->enum('status', ['pending', 'in-progress', 'closed', 'resolved', 'on-hiatus'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeliharaan', function (Blueprint $table) {
            // Revert issue_id to not nullable and remove default value
            $table->unsignedBigInteger('issue_id')->nullable(false)->default(0)->change();

            // Revert part_type_id to not nullable
            $table->unsignedBigInteger('part_type_id')->nullable(false)->change();

            // Revert room_id to not nullable
            $table->unsignedBigInteger('room_id')->nullable(false)->change();

            // Drop the status column
            $table->dropColumn('status');
        });
    }
};
