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
        Schema::create('spl_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spl_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); // ID Karyawan 
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->decimal('total_jam', 5, 2)->default(0);
            $table->decimal('total_konversi', 5, 2)->default(0); // Hasil perhitungan rumus [cite: 7]
            $table->text('alasan_verifikasi')->nullable(); // Jika dibatalkan SDM [cite: 48]
            $table->boolean('is_verified')->default(true); // Verifikasi per karyawan [cite: 34, 47]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spl_details');
    }
};
