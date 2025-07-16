<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $table = 'prodi'; // atau nama tabel yang sesuai
    protected $fillable = ['prodi', 'jenjang'];

    public function pimpinanProdis()
{
    return $this->hasMany(PimpinanProdi::class, 'prodi_id');
}
}
