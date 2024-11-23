<?php

namespace Database\Seeders;

use App\Models\Jenis; // Pastikan model "Jenis" sudah di-import
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use DB;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Jenis::truncate();
        Schema::enableForeignKeyConstraints();

        // Data jenis laporan dengan ID yang ditentukan
        $data = [
            ['id' => 1, 'name_jenis' => 'Remote TV', 'kategori_id' => 1],
            ['id' => 2, 'name_jenis' => 'Remote AC', 'kategori_id' => 1],
            ['id' => 3, 'name_jenis' => 'Remote InFocus', 'kategori_id' => 1],
            ['id' => 4, 'name_jenis' => 'Kabel InFocus', 'kategori_id' => 1],
            ['id' => 5, 'name_jenis' => 'Spidol', 'kategori_id' => 1],
            ['id' => 6, 'name_jenis' => 'Penghapus Papan Tulis', 'kategori_id' => 1],
            ['id' => 7, 'name_jenis' => 'Sabun Cuci Tangan', 'kategori_id' => 1],
            ['id' => 8, 'name_jenis' => 'Kotoran Di Toilet', 'kategori_id' => 1],
            ['id' => 9, 'name_jenis' => 'Lampu', 'kategori_id' => 1],
            ['id' => 10, 'name_jenis' => 'Kabel LAN', 'kategori_id' => 2],
            ['id' => 11, 'name_jenis' => 'AC Tidak Dingin', 'kategori_id' => 2],
            ['id' => 12, 'name_jenis' => 'Keramik Lantai', 'kategori_id' => 2],
            ['id' => 13, 'name_jenis' => 'Pintu Rusak', 'kategori_id' => 2],
            ['id' => 14, 'name_jenis' => 'Kursi Rusak', 'kategori_id' => 2],
            ['id' => 15, 'name_jenis' => 'Gorden Rusak', 'kategori_id' => 2],
            ['id' => 16, 'name_jenis' => 'Colokan Tidak Berfungsi', 'kategori_id' => 2],
            ['id' => 17, 'name_jenis' => 'Keran Kamar Mandi Tidak Berfungsi', 'kategori_id' => 2],
            ['id' => 18, 'name_jenis' => 'Internet Tidak Lancar', 'kategori_id' => 2],
            ['id' => 19, 'name_jenis' => 'Air Wastafel Kamar Mandi Tidak Berfungsi', 'kategori_id' => 2],
            ['id' => 20, 'name_jenis' => 'Gantungan Kamar Mandi', 'kategori_id' => 2],
            ['id' => 21, 'name_jenis' => 'Refill Galon', 'kategori_id' => 2]
        ];

        Jenis::insert($data);
    }
}