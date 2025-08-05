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
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign(['id_sesi']); // Hapus foreign key id_kelas
            $table->dropColumn('id_sesi'); // Hapus kolom id_kelas jika diperlukan
    // Hapus kolom id_kelas jika diperlukan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('kelas', function (Blueprint $table) {
        //     $table->foreignId('id_sesi')->nullable();

        //     // Menambahkan constraint foreign key
        //     $table->foreign('id_sesi')->references('id_sesi')->on('sesi');
        // });
    }
};
