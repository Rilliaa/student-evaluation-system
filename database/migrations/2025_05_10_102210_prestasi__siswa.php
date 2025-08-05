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
        Schema::create('prestasi_siswa', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('id_murid');
            $table->foreignId('id_prestasi');
            $table->timestamps();

            $table->foreign('id_murid')->references('id_murid')->on('murids');
            $table->foreign('id_prestasi')->references('id_prestasi')->on('prestasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi_siswa', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['id_murid']);
            $table->dropForeign(['id_prestasi']);
        });
        
        // Drop the table
        Schema::dropIfExists('prestasi_siswa');
    }
    
};
