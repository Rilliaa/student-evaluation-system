<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('murids', function (Blueprint $table) {
            $table->foreignId('id_nilai')->nullable();

            // Menambahkan constraint foreign key
            $table->foreign('id_nilai')->references('id_nilai')->on('nilais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('murids', function (Blueprint $table) {
        //     // Menghapus constraint foreign key
        //     $table->dropForeign(['id_nilai']);

        //     // Menghapus kolom
        //     $table->dropColumn('id_nilai');
        // });
    }
};
