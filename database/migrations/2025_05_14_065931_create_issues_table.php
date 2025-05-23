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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('description');
            $table->string('status');
            $table->unsignedBigInteger('room_id'); // Foreign key to rooms table
            $table->unsignedBigInteger('part_type_id'); // Foreign key to building_parts table
            $table->string('part_name');

            // Define foreign key constraints
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('part_type_id')->references('id')->on('building_parts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
