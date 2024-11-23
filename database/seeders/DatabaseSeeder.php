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
        $this->call(RoleSeeder::class); // Memastikan role ada lebih dahulu

        \App\Models\User::firstOrCreate(
            ['email' => 'yusuf@gmail.com'],
            [
                'name' => 'yusuf',
                'password' => bcrypt('ucup1234'),
                'role_id' => 2
            ]
        );
        
        \App\Models\User::firstOrCreate(
            ['email' => 'septianhadinugroho4@gmail.com'],
            [
                'name' => 'Septian Hadi Nugroho',
                'password' => bcrypt('hadi1234'),
                'role_id' => 2
            ]
        );
        
        \App\Models\User::firstOrCreate(
            ['email' => 'adminlaptop123@gmail.com'],
            [
                'name' => 'admin',
                'password' => bcrypt('admin123'),
                'role_id' => 1
            ]
        );        
    }
}
