<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportMahasiswa implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row){
            Mahasiswa::create([
'nim' => $row[0], // Ensure these match the heading names in your Excel file
            'nama' => $row[1],
            'jurusan_id' => $row[2],
            'prodi_id' => $row[3],
            'gender' => $row[4],
            'image' => $row[5],

            ]);
        }


    }
}
