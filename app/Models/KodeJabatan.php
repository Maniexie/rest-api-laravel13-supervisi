<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeJabatan extends Model
{
    protected $table = 'k_jabatan';
    protected $primaryKey = 'kode_jabatan';
    protected $keyType = 'string';

        protected $fillable = [
        'kode_jabatan',
        'nama_jabatan',
    ];
    public $incrementing = false;
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'kode_jabatan', 'kode_jabatan');
        }

}
