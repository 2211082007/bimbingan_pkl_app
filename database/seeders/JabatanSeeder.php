<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatanData = [
            ['Ketua Jurusan'],
            ['Sekretasris Jurusan'],
            ['Koordinator Program'],
            ['Dosen'],
        ];
        foreach($jabatanData as $data){
            DB::table('jabatan')->insert([
                'jabatan' => $data[0]
            ]);
        }
    }
}
