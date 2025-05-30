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
            $table->dropColumn('routine');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeliharaan', function (Blueprint $table) {
            $table->string('routine')->nullable(); // Adjust the column type and constraints as needed
        });
    }
};
