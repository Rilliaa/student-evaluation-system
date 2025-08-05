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
        Schema::table('arsip', function (Blueprint $table) {
            $table->dropForeign(['id_murid']);
            $table->dropForeign(['id_ta']);
            $table->dropForeign(['id_kelas']);

            $table->dropColumn('id_ta'); 
            $table->dropColumn('id_kelas'); 
            $table->dropColumn('id_murid'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('arsip', function (Blueprint $table) {
            //
        });
    }
};
