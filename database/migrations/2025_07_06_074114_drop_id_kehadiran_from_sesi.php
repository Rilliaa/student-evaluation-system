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

            $table->dropForeign(['id_kehadiran']);
            $table->dropForeign(['id_kelas']);

            $table->dropColumn('id_kehadiran'); 
            $table->dropColumn('id_kelas'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesi', function (Blueprint $table) {
            //
        });
    }
};
