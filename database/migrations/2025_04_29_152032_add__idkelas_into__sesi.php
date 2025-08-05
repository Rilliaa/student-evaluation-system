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
        Schema::table('sesi', function (Blueprint $table) {
            $table->foreignId('id_kelas')->nullable();

            // Menambahkan constraint foreign key
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesi', function (Blueprint $table) {
            $table->dropForeign(['id_kelas']); // Hapus foreign key id_kelas
            $table->dropColumn('id_kelas'); // Hapus kolom id_kelas jika diperlukan
    // Hapus kolom id_kelas jika diperlukan
        });
    }
};
