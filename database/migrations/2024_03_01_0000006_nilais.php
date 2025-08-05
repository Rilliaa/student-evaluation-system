<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->foreignId('id_murid');
            $table->foreignId('id_mapel');
            $table->decimal('nilai', 5, 2); // Misalnya, menggunakan decimal untuk menyimpan nilai
            $table->string('semester'); // Contoh: "Kelas 11 Semester 1"
            $table->timestamps();


            $table->foreign('id_murid')->references('id_murid')->on('murids')->onDelete('cascade');
            $table->foreign('id_mapel')->references('id_mapel')->on('mapels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilais');
    }
};

