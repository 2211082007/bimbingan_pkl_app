<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataJurusan = [
                ['AN', 'Administrasi Niaga'],
                ['AK', 'Akuntansi'],
                ['BI', 'Bahasa Inggris'],
                ['EE', 'Teknik Elektro'],
                ['ME', 'Teknik Mesin'],
                ['SP', 'Teknik Sipil'],
                ['TI', 'Teknologi Informasi'],
        ];

        foreach ($dataJurusan as $data) {
            DB::table('jurusan')->insert([
                'kode_jurusan'=>$data[0],
                'jurusan'=>$data[1],
            ]);
        }
    }
}
