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
            $table->unsignedBigInteger('user_id')->nullable()->after('id'); // Add user_id column
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Add foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key constraint
            $table->dropColumn('user_id'); // Drop the user_id column
        });
    }
};
