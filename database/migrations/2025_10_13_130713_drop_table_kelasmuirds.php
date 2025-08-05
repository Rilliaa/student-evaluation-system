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
        Schema::table('kelas_murids', function (Blueprint $table) {
            $table->dropForeign(['id_kelas']); // Hapus foreign key id_kelas
            $table->dropForeign(['id_murid']); // Hapus foreign key id_kelas
            
            $table->dropColumn('id_kelas'); // Hapus kolom id_kelas jika diperlukan
            $table->dropColumn('id_murid'); // Hapus kolom id_kelas jika diperlukan
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
