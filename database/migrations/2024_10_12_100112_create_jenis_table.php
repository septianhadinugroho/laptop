<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisTable extends Migration
{
    public function up()
    {
        Schema::create('jenis', function (Blueprint $table) {
            $table->id(); // Kolom ID
            $table->string('name_jenis'); // Kolom name_jenis
            $table->timestamps(); // Kolom timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis');
    }
}
