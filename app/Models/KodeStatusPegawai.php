<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeStatusPegawai extends Model
{
     protected $table = 'k_status_pegawai';
    protected $primaryKey = 'kode_status_pegawai';
    protected $keyType = 'string';

        protected $fillable = [
        'kode_status_pegawai',
        'nama_status_pegawai',
    ];
    public $incrementing = false;
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'kode_status_pegawai', 'kode_status_pegawai');
        }

}
