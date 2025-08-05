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
            $table->foreignId('id_mapel');
            // $table->foreignId('id_ortu');
            $table->foreign('id_mapel')->references('id_mapel')->on('mapels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_pelajarans', function (Blueprint $table) {
                // Menghapus constraint foreign key
                $table->dropForeign(['id_mapel']);
    
                // Menghapus kolom
                $table->dropColumn('id_mapel');
            });
    }
};
