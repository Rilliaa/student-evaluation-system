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
        Schema::create('mapels', function (Blueprint $table) {
            $table->id('id_mapel');
            $table->string('kode_mapel')->unique();
            $table->string('nama_mapel');
            // $table->foreignId('id_guru');
            // $table->foreign('id_guru')->references('id_guru')->on('gurus')->onDelete('cascade');
            
            $table->timestamps();

            // $table->foreign('role')->references('id_roles')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapels');
    }
};
