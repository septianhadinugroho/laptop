<?php

namespace Database\Seeders;

use App\Models\Pelaporan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PelaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Pelaporan::truncate();
        Schema::enableForeignKeyConstraints();

        // Data dummy pelaporan
        $data = [
            [
                'judul' => 'Laporan Kerusakan AC',
                'kategori_id' => 1,
                'jenis_id' => 11,
                'deskripsi' => 'AC tidak dingin di ruang kelas A101',
                'tanggal_laporan' => '2024-01-15',
                'media' => 'images/2023-05-30-082142077.mp4',
                'nama_pelapor' => 'Yusuf Ginanjar', // Updated name
                'lokasi' => 'Ruang A101',
                'user_id' => 1,
                'status_id' => 1
            ],
            [
                'judul' => 'Laporan Kehilangan Remote TV',
                'kategori_id' => 1,
                'jenis_id' => 1,
                'deskripsi' => 'Remote TV hilang di ruang meeting utama',
                'tanggal_laporan' => '2024-01-20',
                'media' => 'media/missing_remote.jpg',
                'nama_pelapor' => 'Yusuf Ginanjar', // Updated name
                'lokasi' => 'Ruang Meeting Utama',
                'user_id' => 1,
                'status_id' => 2
            ],
            [
                'judul' => 'Kerusakan Pintu',
                'kategori_id' => 2,
                'jenis_id' => 13,
                'deskripsi' => 'Pintu ruang B202 rusak dan tidak bisa terkunci',
                'tanggal_laporan' => '2024-01-22',
                'media' => 'media/broken_door.jpg',
                'nama_pelapor' => 'Yusuf Ginanjar', // Updated name
                'lokasi' => 'Ruang B202',
                'user_id' => 1,
                'status_id' => 3
            ],
            [
                'judul' => 'Lampu Ruang Lab Mati',
                'kategori_id' => 1,
                'jenis_id' => 9,
                'deskripsi' => 'Lampu di ruang laboratorium komputer tidak menyala',
                'tanggal_laporan' => '2024-01-25',
                'media' => 'media/lamp_off.jpg',
                'nama_pelapor' => 'Yusuf Ginanjar', // Updated name
                'lokasi' => 'Laboratorium Komputer',
                'user_id' => 1,
                'status_id' => 1
            ],
            [
                'judul' => 'Gorden Kamar Mandi Rusak',
                'kategori_id' => 2,
                'jenis_id' => 15,
                'deskripsi' => 'Gorden kamar mandi di gedung utama sobek',
                'tanggal_laporan' => '2024-01-30',
                'media' => 'media/broken_curtain.jpg',
                'nama_pelapor' => 'Yusuf Ginanjar', // Updated name
                'lokasi' => 'Kamar Mandi Gedung Utama',
                'user_id' => 1,
                'status_id' => 2
            ]
        ];

        Pelaporan::insert($data);
    }
}
