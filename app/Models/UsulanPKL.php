<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UsulanPKL extends Model
{
    use HasFactory;

    protected $table = 'usulan_pkl';
    protected $primaryKey = 'id_usulan';
    protected $fillable = [
        'mhs_id', 'nama_perusahaan', 'deskripsi', 'upload_file',
        'pembimbing_id', 'konfirmasi'
    ];

    // Relasi dengan Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mhs_id', 'id_mhs');
    }

    // Relasi dengan Dosen
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_id', 'id_dosen');
    }

    public function pembimbing()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing_id', 'id_dosen');
    }

    // Relasi dengan BimbinganPKL
    public function bimbingan()
    {
        return $this->hasMany(BimbinganPKL::class, 'usulan_id');
    }


    // Event setelah UsulanPKL dibuat
    public static function boot()
    {
        parent::boot();

    static::created(function ($UsulanPkl) {
        // Menggunakan 'id_usulan' yang benar sebagai referensi

        // NilaiPembimbingPKL::create([
        //     'usulan_id' => $UsulanPkl->id_usulan,  // Pastikan kolom 'id_usulan' ada di tabel yang sesuai
        // ]);
        // NilaiPengujiPKL::create([
        //     'usulan_id' => $UsulanPkl->id_usulan,  // Pastikan kolom 'id_usulan' ada di tabel yang sesuai
        // ]);
    });
}
}

