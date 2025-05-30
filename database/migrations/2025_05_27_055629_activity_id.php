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
        Schema::table('maintenances', function (Blueprint $table) {
            $table->unsignedBigInteger('check_id')->nullable()->after('routine'); // Add check_id column
            $table->foreign('check_id')->references('id')->on('checks')->onDelete('cascade'); // Add foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            $table->dropForeign(['check_id']); // Drop foreign key constraint
            $table->dropColumn('check_id');   // Drop check_id column
        });
    }
};
