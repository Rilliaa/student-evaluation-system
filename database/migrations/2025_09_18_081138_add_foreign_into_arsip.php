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
        Schema::table('arsip', function (Blueprint $table) {
            $table->foreignId('id_murid');
            $table->foreignId('id_ta');
            $table->foreignId('id_kelas');
            $table->timestamps();
            $table->foreign('id_murid')->references('id_murid')->on('murids');
            $table->foreign('id_ta')->references('id_ta')->on('tahun_ajaran');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsip', function (Blueprint $table) {
            //
        });
    }
};
