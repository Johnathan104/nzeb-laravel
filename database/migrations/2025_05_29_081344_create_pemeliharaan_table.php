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
        Schema::create('pemeliharaan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id'); // Linked to rooms table
            $table->string('lokasi'); // Lokasi
            $table->date('tanggal_mulai'); // Tanggal Mulai
            $table->unsignedBigInteger('user_id'); // Linked to users table
            $table->unsignedBigInteger('issue_id'); // Linked to issues table
            $table->unsignedBigInteger('part_type_id'); // Linked to building parts table
            $table->enum('jenis_pemeliharaan', ['rutin', 'korektif', 'darurat']); // Jenis Pemeliharaan
            $table->enum('kondisi', ['baik', 'cukup', 'buruk']); // Kondisi
            $table->string('keterangan'); // Keterangan
            $table->string('durasi'); // Durasi
            $table->string('estimasi'); // Estimasi
            $table->string('supervisor')->nullable(); // Supervisor (nullable)
            $table->date('tanggal_pemohonan')->nullable(); // Tanggal Pemohonan (nullable)
            $table->string('nama_petugas')->nullable(); // Nama Petugas (nullable)
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
            $table->foreign('part_type_id')->references('id')->on('building_parts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaan');
    }
};
