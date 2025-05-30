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
            $table->string('mode_kegagalan'); // Mode Kegagalan
            $table->integer('severity'); // Severity
            $table->integer('occurrence'); // Occurrence
            $table->integer('detection'); // Detection
            $table->string('rekomendasi_tindakan')->nullable(); // Rekomendasi Tindakan (nullable)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropColumn('mode_kegagalan');
            $table->dropColumn('severity');
            $table->dropColumn('occurrence');
            $table->dropColumn('detection');
            $table->dropColumn('rekomendasi_tindakan');
        });
    }
};
