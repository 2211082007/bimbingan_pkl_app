<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataProdi = [
            ['3AB', 'D3 - Administrasi Bisnis', '1', 'D3'],
            ['3UPW', 'D3 - Usaha Perjalanan Wisata', '1', 'D3'],
            ['4DP', 'D4 - Destinasi Pariwisata', '1', 'D4'],
            ['3AK', 'D3 - Akuntansi', '2', 'D3'],
            ['3AK-SS', 'D3 - Akuntansi (Solok Selatan)', '2', 'D3'],
            ['4AK', 'D4 - Akuntansi', '2', 'D4'],
            ['3BI', 'D3 - Bahasa Inggris', '3', 'D3'],
            ['4BI', 'D3 - Bahasa Inggris Untuk Komunikasi Bisnis dan Profesional', '3', 'D4'],
            ['2EC', 'D2 - Jalur Cepat Instalasi dan Perawatan Kabel Bertenaga Rendah', '4', 'D2'],
            ['3TL', 'D3 - Teknik Listrik', '4', 'D3'],
            ['3EC', 'D3 - Teknik Elektronika ', '4', 'D3'],
            ['3TELKOM', 'D3 - Teknik Telekomunikasi', '4', 'D3'],
            ['3TL-P', 'D3 - Teknik Listrik (Palelawan)', '4', 'D3'],
            ['4EC', 'D4 - Teknik Elektronika', '4', 'D4'],
            ['4TELKOM', 'D4 - Teknik Telekomunikasi', '4', 'D4'],
            ['4TRIL', 'D4 - Teknologi Rekayasa Instalasi Listrik', '4', 'D4'],
            ['3TM', 'D3 - Teknik Mesin', '5', 'D3'],
            ['4TAB', 'D3 - Teknik Alat Berat', '5', 'D3'],
            ['4TM', 'D4 - Teknik Manufaktur', '5', 'D4'],
            ['4RPM', 'D4 - Rekayasa Perancangan Mekanik', '5', 'D4'],
            ['3TS', 'D3 - Teknik Sipil', '6', 'D4'],
            ['3TS-TD', 'D3 - Teknik Sipil (Tanah Datar)', '6', 'D4'],
            ['4MRK', 'D4 - Manajemen Rekayasa Konstruksi', '6', 'D4'],
            ['4PJJ', 'D4 - Perancangan Jalan dan Jembatan', '6', 'D4'],
            ['3MI', 'D3 - Manajemen Informatika', '7', 'D3'],
            ['3TK', 'D3 - Teknik Komputer', '7', 'D3'],
            ['4TRPL', 'D4 - Teknologi Rekayasa Perangkat Lunak', '7', 'D4'],
            ['3SI-TD', 'D3 - SISTEM INFORMASI (TANAH DATAR)', '7', 'D3'],
            ['3TK-SS', 'D3 - Teknik Komputer (Solok Selatan)', '7', 'D3'],
            ['3MI-P', 'D3 - Manajemen Informatika (Pelalawan)', '7', 'D3'],
        ];

        foreach ($dataProdi as $data) {
            DB::table('prodi')->insert([
                'kode_prodi'=>$data[0],
                'prodi'=>$data[1],
                'jurusan_id'=>$data[2],
                'jenjang'=>$data[3],
            ]);
        }
    }
}
