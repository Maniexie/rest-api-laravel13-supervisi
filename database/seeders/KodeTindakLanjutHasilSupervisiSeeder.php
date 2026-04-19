<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KodeTindakLanjutHasilSupervisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder k_jabatan
        DB::table('k_tindak_lanjut_hasil_supervisi')->insert([
            [
                'kode_tindak_lanjut' => 'WS',
                'nama_tindak_lanjut' => 'WorkShop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_tindak_lanjut' => 'SM',
                'nama_tindak_lanjut' => 'Seminar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
