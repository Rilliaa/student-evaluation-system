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
        Schema::create('ortus', function (Blueprint $table) {
            $table->id('id_ortu');
            $table->string('nama_ortu');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->foreignId('id_murid');
            $table->foreignId('id_kelas');
            $table->string('alamat');
            $table->string('email');
            $table->foreignId('role');
            $table->timestamps();

            $table->foreign('role')->references('id_roles')->on('roles')->onDelete('cascade');
            $table->foreign('id_murid')->references('id_murid')->on('murids')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ortus');
    }
};
