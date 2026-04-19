<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPenilaian extends Model
{
    protected $table = 'k_penilaian';
    protected $primaryKey = 'kode_kategori_penilaian';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'kode_kategori_penilaian',
        'nama_kategori_penilaian',
    ];
}
