<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen'; // Pastikan ini adalah nama tabel yang benar
    protected $primaryKey = 'id_dosen'; // Pastikan ini adalah primary key yang benar

    protected $fillable = [
        'nidn', 'nama','nip', 'gender', 'tempt_lahir', 'tgl_lahir',
         'pendidikan', 'jurusan_id', 'prodi_id',
        'alamat', 'email', 'no_hp', 'image', 'status'
    ]; // Field yang bisa diisi

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id_prodi');
    }
    public function pimpinan_prodi()
{
    return $this->belongsTo(Prodi::class, 'prodi_id', 'id_prodi');
}

}
