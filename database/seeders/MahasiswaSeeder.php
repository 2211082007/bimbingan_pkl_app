<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataMahasiswa = [
            ['2211082004', 'Athira Rahmadini', 7, 27, 'Perempuan','12345678', 'athira@gmail.com','default.jpg'],
            ['2211082005', 'Puti Hanifah Marsla', 7, 27, 'Perempuan','12345678','puti@gmail.com',  'default.jpg'],
            ['2211082007', 'Fadila Islami Nisa', 7,27, 'Perempuan','12345678','fadila@gmail.com', 'default.jpg'],
        ];

        foreach ($dataMahasiswa as $data){
            DB::table('mahasiswa')->insert([
                'nim'=>$data[0],
                'nama'=>$data[1],
                'jurusan_id'=>$data[2],
                'prodi_id'=>$data[3],
                'gender'=>$data[4],
                'password'=>$data[5],
                'email'=>$data[6],
                'image'=>$data[7],
            ]);
        }
    }

    }
