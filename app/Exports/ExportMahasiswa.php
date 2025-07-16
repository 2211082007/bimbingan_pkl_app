<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportMahasiswa implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('mahasiswa')
            ->join('jurusan', 'mahasiswa.jurusan_id', '=', 'jurusan.id_jurusan')
            ->join('prodi', 'mahasiswa.prodi_id', '=', 'prodi.id_prodi')
            ->select('mahasiswa.id_mhs', 'mahasiswa.nim', 'mahasiswa.nama', 'jurusan.jurusan', 'prodi.prodi', 'mahasiswa.gender', 'mahasiswa.image')
            ->orderBy('id_mhs')
            ->get();
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'ID_Mahasiswa',
            'NIM',
            'Nama',
            'Jurusan',
            'Prodi',
            'Jenis Kelamin',
            'Image',
        ];
    }
}
