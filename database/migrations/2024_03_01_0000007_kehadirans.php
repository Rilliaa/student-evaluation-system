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
   
        Schema::create('kehadirans', function (Blueprint $table) {
            $table->id(); // Kolom primary key yang diinkrementasi otomatis
            $table->foreignId('id_murid'); // Kolom id_murid sebagai foreign key
            $table->foreignId('id_kelas'); // Kolom id_murid sebagai foreign key
            $table->date('tanggal');
            $table->string('status');
            $table->string('keterangan')->nullable();
            $table->timestamps();
            
            $table->foreign('id_murid')->references('id_murid')->on('murids');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kehadirans');
    }
};
