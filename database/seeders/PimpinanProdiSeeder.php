<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PimpinanProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $PPData = [
            [1, 3, 27, 160, '2022-2026', '1'],
            [2, 3, 25, 351, '2022-2026', '1'],
            [3, 3, 26, 312, '2022-2026', '1'],

        ];
        foreach ($PPData as $data) {
            DB::table('pimpinan_prodi')->insert([
                'id_pimpinan_prodi' => $data[0],
                'jabatan_id' => $data[1],
                'prodi_id' => $data[2],
                'dosen_id' => $data[3],
                'periode' => $data[4],
                'status' => $data[5],
            ]);
        }
    }
}
