<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('routine'); // Jenis Kegiatan/Pekerjaan
            $table->unsignedBigInteger('room_id')->nullable(); // Foreign key for room
            $table->string('pelaksana');// Pelaksana/Pelaksana Utama
            $table->string('location')->nullable(); // Lokasi Kegiatan/Pekerjaan
            $table->string('operator')->nullable(); // Operator
            $table->date('date_start');
            $table->date('date_end');// Tanggal
            $table->boolean('safety_helmet')->default(false); // Safety Helmet
            $table->boolean('safety_vest')->default(false); // Safety Vest
            $table->boolean('safety_shoes')->default(false); // Safety Shoes
            $table->boolean('gloves')->default(false); // Sarung Tangan
            $table->boolean('mask')->default(false); // Masker
            $table->string('pemohon')->nullable(); // Pemohon
            $table->boolean('full_body_harness')->default(false); // Full Body Harness
            $table->text('work_steps')->nullable(); // Uraian Langkah-Langkah Kerja
            $table->text('hazards')->nullable(); // Potensi Bahaya, PAK, dan Pencemaran Lingkungan
            $table->text('mitigation')->nullable(); // Penanggulangan
            $table->text('status')->default('diproses');
            $table->timestamps(); // Created_at and updated_at timestamps

            // Foreign key constraint
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
