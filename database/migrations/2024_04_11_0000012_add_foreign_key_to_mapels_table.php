<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('mapels', function (Blueprint $table) {
            $table->foreignId('id_guru');
            $table->foreign('id_guru')->references('id_guru')->on('gurus')->onDelete('cascade');
        
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mapels', function (Blueprint $table) {
            //
        });
    }
};
