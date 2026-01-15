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
        Schema::create('spls', function (Blueprint $table) {
            $table->id();   
            $table->string('no_spl')->unique();
            $table->date('tanggal');
            $table->enum('jenis_lembur', ['Reguler', 'Off'])->nullable(); // Dipilih oleh Admin SDM [cite: 33]
            $table->string('status_approval')->default('Pending'); // Pending, Approved Manager, Approved SDM [cite: 31, 32]
            $table->foreignId('created_by'); // Siapa pembuatnya (SPV/Manager) 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spls');
    }
};
