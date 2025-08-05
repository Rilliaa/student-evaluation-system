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
            $table->foreignId('id_ortu')->nullable()->onDelete('set null');
            // $table->foreignId('id_ortu');
            $table->foreign('id_ortu')->references('id_ortu')->on('ortus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('murids', function (Blueprint $table) {
            $table->dropForeign(['id_ortu']);
            $table->dropColumn('id_ortu');
        });
    }
};
