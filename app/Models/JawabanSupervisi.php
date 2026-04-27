<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSupervisi extends Model
{
    protected $table = 'jawaban_supervisi';
    protected $fillable = [
        'id_jadwal_supervisi',
        'id_item_penilaian',
        'id_kepala_sekolah',
        'id_guru',
        'jawaban',
        'tanggal_pengisian'
    ];
    }
