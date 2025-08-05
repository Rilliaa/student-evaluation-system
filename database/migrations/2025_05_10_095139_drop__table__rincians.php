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
        Schema::table('rincians', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['id_kelas']);
            $table->dropForeign(['id_murid']);
            $table->dropForeign(['id_guru']);
            $table->dropForeign(['id_nilai']);
            $table->dropForeign(['id_mapel']);
        });
        
        // Drop the table
        Schema::dropIfExists('rincians');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('rincians', function (Blueprint $table) {
            $table->id('id_rincian');
            $table->foreignId('id_kelas');
            $table->foreignId('id_murid');
            $table->foreignId('id_guru');
            $table->foreignId('id_nilai');
            $table->foreignId('id_mapel');
            $table->timestamps();

            // Restore foreign key constraints
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_guru')->references('id_guru')->on('gurus')->onDelete('cascade');
            $table->foreign('id_murid')->references('id_murid')->on('murids')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id_mapel')->on('mapels')->onDelete('cascade');
            $table->foreign('id_nilai')->references('id_nilai')->on('nilais')->onDelete('cascade');
        });
    }
};
