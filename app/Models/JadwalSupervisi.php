<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalSupervisi extends Model
{
    protected $table = 'jadwal_supervisi';
    protected $primaryKey = 'id_jadwal_supervisi';

    protected $fillable = [
        'id_kepala_sekolah',
        'nama_periode',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
    ];

    public function kepalaSekolah()
    {
        return $this->belongsTo(User::class, 'id_kepala_sekolah' , 'id_user');
    }
}
