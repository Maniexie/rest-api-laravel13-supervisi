<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeTindakLanjutHasilSupervisi extends Model
{
    protected $table = 'k_tindak_lanjut_hasil_supervisi';

    protected $primaryKey = 'kode_tindak_lanjut';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_tindak_lanjut',
        'nama_tindak_lanjut',
    ];

    public function getRouteKeyName(): string
    {
        return 'kode_tindak_lanjut';
    }
}
