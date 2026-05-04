<?php

namespace Database\Seeders;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KepalaSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // 'kode_jabatan' => 'GK',
            //     'kode_golongan' => 'IA',
            //     'kode_status_pegawai' => 'PPPK',
                'nip' => '19800102',
                'nama' => fake('id_ID')->name(),
                'email' => fake('id_ID')->email(),
                'username' => 'kepsek',
                'password' => Hash::make('password123'),
                'nomor_hp' => '081234567890',
                'alamat' => 'Pekanbaru',
                'jenis_kelamin' => 'perempuan',
                'isValidator' => true,
                'role' => 'kepala_sekolah',
                'created_at' => now(),
                'updated_at' => now(),
        ]);
    }
}
