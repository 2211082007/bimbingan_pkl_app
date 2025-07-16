<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataGolongan=[
            ['Asisten Ahli'],
            ['Lektor'],
            ['Lektor Kepala'],
            ['Guru Besar'],

        ];
        foreach($dataGolongan as $data){
            DB::table('golongan')->insert([
                'golongan'=>$data[0],

            ]);
    }
}
}
