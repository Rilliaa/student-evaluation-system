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
        
        Schema::create('tes_users', function (Blueprint $table) {
            $table->id('id_tes');
            $table->foreignId('id_guru');
            $table->foreignId('id_murid');
            $table->foreignId('id_ortu');

            
            $table->foreign('id_guru')->references('id_guru')->on('gurus');
            $table->foreign('id_murid')->references('id_murid')->on('murids');
            $table->foreign('id_ortu')->references('id_ortu')->on('ortus');
        


            // $table->foreign('role')->references('id_roles')->on('roles')->onDelete('cascade');
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
