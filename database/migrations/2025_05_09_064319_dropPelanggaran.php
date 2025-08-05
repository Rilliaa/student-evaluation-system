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
        // Schema::dropIfExists('pelanggaran');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::create('pelanggaran', function (Blueprint $table) {
        //     $table->id('id_pelanggaran');
        //     $table->string('nama_pelanggaran');
        //     $table->integer('poin')->default(0);
        //     $table->timestamps();
        // });
    }
};
