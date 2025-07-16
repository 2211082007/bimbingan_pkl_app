<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BimbinganPKL extends Model
{
    use HasFactory;

    protected $table = 'bimbingan_pkl'; // Nama tabel
    public $timestamps = false;
    protected $primaryKey = 'id_bimbinganPkl'; // Nama primary key
    protected $fillable = [
        'usulan_id',
        'laporan',
        'kegiatan',
        'tgl_awal',
        'tgl_akhir',
        'verif',
        'catatan',

    ];
    public function usulan_pkl()
{
    return $this->belongsTo(UsulanPKL::class, 'usulan_id','id_usulan');
}
// BimbinganPKL model
public function mahasiswa()
{
    return $this->belongsTo(Mahasiswa::class, 'mhs_id');
}


}
