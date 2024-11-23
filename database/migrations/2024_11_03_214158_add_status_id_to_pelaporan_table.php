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
            $table->unsignedBigInteger('status_id')->after('lokasi');
            $table->foreign('status_id')->references('id')->on('status');
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
            Schema::table('pelaporan', function (Blueprint $table) {
                $table->dropForeign(['status_id']); // Menghapus foreign key
                $table->dropColumn('status_id'); // Menghapus kolom status_id
            });
        });
    }
};
