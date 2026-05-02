<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeGolongan extends Model
{
    protected $table = 'k_golongan';
    protected $primaryKey = 'kode_golongan';
    protected $keyType = 'string';

    protected $fillable = [
        'kode_golongan',
        'nama_golongan',
    ];
    public $incrementing = false;
    public $timestamps = false;
public function users()
{
    return $this->hasMany(User::class, 'kode_golongan', 'kode_golongan');
}
    }

