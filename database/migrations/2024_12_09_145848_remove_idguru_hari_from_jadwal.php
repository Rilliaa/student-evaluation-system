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
        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
            $table->dropForeign(['id_guru']); // Hapus foreign key id_kelas
            $table->dropColumn('id_guru'); // Hapus kolom id_kelas jika diperlukan
            $table->dropColumn('hari'); // Hapus kolom id_kelas jika diperlukan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
