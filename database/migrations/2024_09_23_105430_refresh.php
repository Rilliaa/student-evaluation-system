<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jam_pelajarans', function (Blueprint $table) {
            // Mengubah kolom id_jadwal menjadi nullable
            $table->foreignId('id_jadwal')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('jam_pelajarans', function (Blueprint $table) {
            // Mengembalikan kolom id_jadwal menjadi tidak nullable
            $table->foreignId('id_jadwal')->change();
        });
    }
};
