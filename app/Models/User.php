<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // 1. Import trait

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_user',
        'kode_jabatan',
        'kode_golongan',
        'kode_status_pegawai',
        'nip',
        'nama',
        'email',
        'username',
        'password',
        'nomor_hp',
        'alamat',
        'role',
        'isValidator',
        'jenis_kelamin',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function kode_jabatan()
    {
        return $this->belongsTo(KodeJabatan::class, 'kode_jabatan', 'kode_jabatan');
    }

    public function kode_golongan()
    {
        return $this->belongsTo(KodeGolongan::class, 'kode_golongan', 'kode_golongan');
    }


    public function kode_status_pegawai()
    {
        return $this->belongsTo(KodeStatusPegawai::class, 'kode_status_pegawai', 'kode_status_pegawai');
    }
}
