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
        // Schema::table('ortus', function (Blueprint $table) {
        //     $table->dropForeign(['id_kelas']); // Hapus foreign key id_kelas
        //     $table->dropColumn('id_kelas'); // Hapus kolom id_kelas jika diperlukan
        // });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('ortus', function (Blueprint $table) {
        //     $table->string('id_kelas'); // Jika ingin membatalkan penghapusan, tambahkan kembali kolom yang dihapus
        // });
    }
};
