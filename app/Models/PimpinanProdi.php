<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PimpinanProdi extends Model
{
    use HasFactory;
    protected $fillable = ['id_pimpinan_prodi', 'jabatan_id', 'prodi_id', 'dosen_id', 'periode', 'status'];
    protected $table = 'pimpinan_prodi';
    public $timestamps = false;
    protected $primaryKey = 'id_pimpinan_prodi';

    public function jabatan()
    {
        return $this->belongsTo(Prodi::class, 'jabatan_id', 'id_jabatan');
    }
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id_prodi');
    }

    public function dosen()
    {
        return $this->belongsTo(Prodi::class, 'dosen_id', 'id_dosen');
    }
}
