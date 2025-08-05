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
        Schema::create('murids', function (Blueprint $table) {
            $table->id('id_murid');
            $table->string('nisn')->unique();
            $table->string('nama_murid');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->foreignId('id_kelas');
            $table->string('tahun_ajaran');
            $table->foreignId('role');

            $table->foreign('role')->references('id_roles')->on('roles')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('murids');
    }
};
