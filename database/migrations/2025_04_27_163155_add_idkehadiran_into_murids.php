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
            $table->foreignId('id_kehadiran')->nullable();

            // Menambahkan constraint foreign key
            $table->foreign('id_kehadiran')->references('id')->on('kehadirans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            $table->dropForeign('id_kehadiran')->nullable();

            // Menambahkan constraint foreign key
            $table->dropColumn('id_kehadiran')->references('id')->on('kehadirans');
        });
    
    }
};
