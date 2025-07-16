<?php

namespace App\Imports;

use App\Models\Dosen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportDosen implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row){
            Dosen::create([
'nidn' => $row[0], // Ensure these match the heading names in your Excel file
            'nama' => $row[1],
            'gender' => $row[2],
            'tempt_lahir' => $row[3],
            'tgl_lahir' => $row[4],
            'pendidikan' => $row[5],
            'jurusan_id' => $row[6],
            'prodi_id' => $row[7],
            'alamat' => $row[8],
            'email' => $row[9],
            'no_hp' => $row[10],
            'images' => $row[11],
            'status' => $row[12],
            ]);
        }

    }
}
