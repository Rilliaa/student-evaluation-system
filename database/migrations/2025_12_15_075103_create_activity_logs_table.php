<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('actor_id'); // ID dari user (Admin/Guru)
            $table->string('actor_type'); // Nama tabel/model: 'User' atau 'Guru'
            $table->string('action'); // Jenis aksi: create, update, delete
            $table->string('object_type'); // Nama tabel/entitas yang dimanipulasi
            $table->unsignedBigInteger('object_id'); // ID data yang dimanipulasi
            $table->json('details')->nullable(); // Informasi detail data
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
