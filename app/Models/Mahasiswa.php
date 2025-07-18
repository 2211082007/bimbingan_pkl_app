<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa'; 
    protected $primaryKey = 'id_mhs';
    protected $fillable = ['nim', 'nama','jurusan_id', 'prodi_id', 'gender', 'image'];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id_prodi');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
    }
    public function usulanpkl()
    {
        return $this->hasOne(UsulanPKL::class, 'mhs_id', 'id_mhs');
    }
}
