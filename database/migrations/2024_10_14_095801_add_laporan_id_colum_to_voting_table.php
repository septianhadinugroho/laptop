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
        Schema::table('voting', function (Blueprint $table) {
            $table->unsignedBigInteger('laporan_id')->after('id');
            $table->foreign('laporan_id')->references('id')->on('pelaporan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voting', function (Blueprint $table) {
            $table->dropForeign(['laporan_id']);
            $table->dropColumn('laporan_id');
        });
    }
};
