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
        Schema::create('pelanggaran_siswa', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('id_murid');
            $table->foreignId('id_pelanggaran');
            $table->timestamps();

            $table->foreign('id_murid')->references('id_murid')->on('murids');
            $table->foreign('id_pelanggaran')->references('id_pelanggaran')->on('pelanggaran');
        });

    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggaran_siswa', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['id_murid']);
            $table->dropForeign(['id_pelanggaran']);
        });
        
        // Drop the table
        Schema::dropIfExists('pelanggaran_siswa');
    }
};
