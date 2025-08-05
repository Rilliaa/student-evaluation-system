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
        Schema::table('kehadirans', function (Blueprint $table) {
            $table->foreignId('id_sesi')->nullable();

            // Menambahkan constraint foreign key
            $table->foreign('id_sesi')->references('id_sesi')->on('sesi');
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
