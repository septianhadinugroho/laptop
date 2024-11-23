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
        Schema::table('pelaporan', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_id')->after('kategori_id');
            $table->foreign('jenis_id')->references('id')->on('jenis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelaporan', function (Blueprint $table) {
            $table->dropForeign(['jenis_id']);
            $table->dropColumn('jenis_id');
        });
    }
};
