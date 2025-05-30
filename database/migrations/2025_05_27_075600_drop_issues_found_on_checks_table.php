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
        Schema::table('checks', function (Blueprint $table) {
            if (Schema::hasColumn('checks', 'issues_found')) {
                $table->dropColumn('issues_found'); // Drop the issues_found column
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checks', function (Blueprint $table) {
            $table->json('issues_found')->default(json_encode([]))->nullable(); // Re-add the issues_found column
        });
    }
};
