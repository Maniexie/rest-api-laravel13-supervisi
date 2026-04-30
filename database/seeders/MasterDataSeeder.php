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

        // Seeder k_penilaian
        DB::table('k_penilaian')->insert([
            [
                'kode_kategori_penilaian' => 'A1',
                'nama_kategori_penilaian' => 'Guru menguasai materi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori_penilaian' => 'A2',
                'nama_kategori_penilaian' => 'Guru menggunakan metode yang tepat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('k_penilaian')->insert([
            [
                'kode_kategori_penilaian' => 'KDSL',
                'nama_kategori_penilaian' => 'Kedisiplinan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori_penilaian' => 'KQ',
                'nama_kategori_penilaian' => 'Kualitas Penilaian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->call(ItemPenilaianSeeder::class);
        DB::table('item_penilaian')->insert([
            [
                'kode_kategori_penilaian' => 'KQ',
                'pernyataan' => 'Guru menguasai materi',
                'versi' => 1,
                'nilai_aiken' => 0,
                'status' => 'tidak_valid',
                'isDigunakan' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_kategori_penilaian' => 'KDSL',
                'pernyataan' => 'Guru menggunakan metode yang tepat',
                'versi' => 1,
                'nilai_aiken' => 0,
                'status' => 'tidak_valid',
                'isDigunakan' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('jadwal_supervisi')->insert([
           'id_kepala_sekolah' => 1,
           'nama_periode' => 'Periode 1',
           'tanggal_mulai' => now(),
           'tanggal_selesai' => date('Y-m-d', strtotime('+1 month')),
           'deskripsi' => 'Jadwal Supervisi Periode 1',
           'created_at' => now(),
           'updated_at' => now(),
        ]);

        DB::table('k_tindak_lanjut_hasil_supervisi')->insert([
            [
                'kode_tindak_lanjut' => 'TL1',
                'nama_tindak_lanjut' => 'Tindak Lanjut 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_tindak_lanjut' => 'TL2',
                'nama_tindak_lanjut' => 'Tindak Lanjut 2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
