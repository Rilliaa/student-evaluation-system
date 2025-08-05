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
        Schema::table('murids', function (Blueprint $table) {
            $table->dropForeign(['id_ortu']); 
            $table->dropForeign(['id_nilai']); 
            $table->dropForeign(['id_kehadiran']);

            $table->dropColumn('id_ortu'); 
            $table->dropColumn('id_nilai'); 
            $table->dropColumn('id_kehadiran'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('murids', function (Blueprint $table) {
        //     $table->foreignId('id_ortu')->nullable();
        //     $table->foreignId('id_kehadiran')->nullable();
        //     $table->foreignId('id_nilai')->nullable();
        //         // Menambahkan constraint foreign key
        //     $table->foreign('id_sesi')->references('id_sesi')->on('sesi');
        //     $table->foreign('id_sesi')->references('id_sesi')->on('sesi');
        //     $table->foreign('id_sesi')->references('id_sesi')->on('sesi');
        // });
    }
};
