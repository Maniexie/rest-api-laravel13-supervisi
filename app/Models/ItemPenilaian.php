<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPenilaian extends Model
{
    protected $table = 'item_penilaian';

    protected $primaryKey = 'id_item_penilaian';

    protected $keyType = 'int';

    public $incrementing = true;

    protected $fillable = [
        'id_item_penilaian',
        'kode_kategori_penilaian',
        'pernyataan',
        'versi',
        'nilai_aiken',
        'status',
        'isDigunakan'
    ];

    public function k_penilaian()
    {
        return $this->belongsTo(KategoriPenilaian::class, 'kode_kategori_penilaian', 'kode_kategori_penilaian');
    }
}
