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
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('lighting')->default(0)->after('room_name'); // Add lighting column
            $table->integer('energy')->default(0)->after('lighting');   // Add energy column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('lighting'); // Remove lighting column
            $table->dropColumn('energy');   // Remove energy column
        });
    }
};
