<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDosen implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('dosen')
        ->join('jurusan', 'dosen.jurusan_id', '=', 'jurusan.id_jurusan')
        ->join('prodi', 'dosen.prodi_id', '=', 'prodi.id_prodi')
        ->select('dosen.id_dosen', 'dosen.nidn', 'dosen.nama','dosen.gender', 'dosen.tempt_lahir','dosen.tgl_lahir','dosen.pendidikan','jurusan.jurusan', 'prodi.prodi' ,'dosen.alamat','dosen.email','dosen.no_hp','dosen.image','dosen.status')
        ->orderBy('id_dosen')
        ->get();
    }
    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'ID_Dosen',
            'NIDN',
            'Nama',
            'Jenis Kelamin',
            'Tempat Lahir',
           'Tanggal Lahir',
            'Pendidikan',
           'Jurusan',
            'Prodi',
            'Alamat',
            'Email',
            'No HP',
            'Image',
            'Status',
        ];
    }
}
