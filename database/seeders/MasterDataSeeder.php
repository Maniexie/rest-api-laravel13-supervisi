<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Seeder k_jabatan
        DB::table('k_jabatan')->insert([
            [
                'kode_jabatan' => 'GK',
                'nama_jabatan' => 'Guru Kelas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_jabatan' => 'KS',
                'nama_jabatan' => 'Kepala Sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seeder k_golongan
        DB::table('k_golongan')->insert([
            [
                'kode_golongan' => 'IA',
                'nama_golongan' => 'Golongan IA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_golongan' => 'IIA',
                'nama_golongan' => 'Golongan II A',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seeder k_status_pegawai
        DB::table('k_status_pegawai')->insert([
            [
                'kode_status_pegawai' => 'PPPK',
                'nama_status_pegawai' => 'Pegawai Pemerintah Perjanjian Kerja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_status_pegawai' => 'PNS',
                'nama_status_pegawai' => 'Pegawai Negeri Sipil',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
