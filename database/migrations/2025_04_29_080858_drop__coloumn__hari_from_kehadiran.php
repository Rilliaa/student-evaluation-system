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
            // Menghapus constraint foreign '
            $table->dropColumn('tanggal');
            $table->dropColumn('hari');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kehadirans', function (Blueprint $table) {
            $table->string('tanggal')->nullable();
            $table->string('hari')->nullable();
        });
    }
};
