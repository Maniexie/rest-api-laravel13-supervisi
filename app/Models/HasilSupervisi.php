<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilSupervisi extends Model
{
    protected $table = 'hasil_supervisi';
    protected $primaryKey = 'id_hasil_supervisi';
    protected $fillable = [
        'id_hasil_supervisi',
        'id_jadwal_supervisi',
        'kode_tindak_lanjut',
        'id_kepala_sekolah',
        'id_guru',
        'nilai',
        'umpan_balik'
    ];


    public function jadwal_supervisi()
    {
        return $this->belongsTo(JadwalSupervisi::class, 'id_jadwal_supervisi');
    }
}
