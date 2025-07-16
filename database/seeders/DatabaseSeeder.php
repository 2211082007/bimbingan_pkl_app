<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call([JurusanSeeder::class,]);
        $this->call([ProdiSeeder::class,]);
        $this->call([GolonganSeeder::class,]);
        $this->call([DosenSeeder::class,]);
        $this->call([MahasiswaSeeder::class,]);
        $this->call([JabatanSeeder::class,]);
        $this->call([PimpinanProdiSeeder::class,]);
        $this->call([RoleUserSeeder::class,]);
    }
}
