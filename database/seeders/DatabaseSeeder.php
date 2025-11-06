<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            KategoriSeeder::class,
            JenisSeeder::class,
            StatusSeeder::class,
            PelaporanSeeder::class // Pastikan nama filenya benar
        ]);

        \App\Models\User::firstOrCreate(
            ['email' => 'yusuf@gmail.com'],
            [
                'name' => 'Yusuf',
                'password' => bcrypt('ucup1234'),
                'role_id' => 2
            ]
        );
        
        \App\Models\User::firstOrCreate(
            ['email' => 'septian@gmail.com'],
            [
                'name' => 'Septian',
                'password' => bcrypt('hadi1234'),
                'role_id' => 2
            ]
        );
        
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Laptop',
                'password' => bcrypt('admin1234'),
                'role_id' => 1
            ]
        );        
    }
}
