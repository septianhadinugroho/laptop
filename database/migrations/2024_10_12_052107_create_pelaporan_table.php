<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelaporan', function (Blueprint $table) {
            $table->id(); // Kolom ID sebagai primary key
            $table->string('judul'); // Judul laporan
            $table->text('deskripsi'); // Deskripsi laporan
            $table->date('tanggal_laporan'); // Tanggal laporan dibuat
            $table->string('media'); // Kolom untuk menyimpan media seperti gambar atau video
            $table->string('nama_pelapor'); // Nama pelapor
            $table->string('lokasi'); // Lokasi laporan
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelaporan'); // Menghapus tabel pelaporan jika migrasi di-rollback
    }
};
