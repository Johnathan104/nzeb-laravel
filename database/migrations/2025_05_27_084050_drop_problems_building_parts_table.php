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
        Schema::table('building_parts', function (Blueprint $table) {
            if (Schema::hasColumn('building_parts', 'problems')) {
                $table->dropColumn('problems'); // Drop the problems column
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('building_parts', function (Blueprint $table) {
            $table->json('problems')->nullable(); // Re-add the problems column
        });
    }
};
