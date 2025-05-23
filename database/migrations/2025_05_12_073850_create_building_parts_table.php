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
        Schema::create('building_parts', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('class'); // Class name
            $table->string('type');
            $table->string('pemeriksaan');
            $table->string('pemeliharaan');
            $table->string('url')->default('');
            $table->string('perawatan'); // Name of the building part
            $table->string('title'); // Name of the building part
            $table->json('locations')->default(json_encode([])); // JSON column for locations, default empty array
            $table->json('problems')->default(json_encode([])); // JSON column for problems, default empty array
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('building_parts');
    }
};
