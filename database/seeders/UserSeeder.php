<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'kode_jabatan' => 'GK',
                'kode_golongan' => 'IA',
                'kode_status_pegawai' => 'PPPK',
                'nip' => '19800101',
                'nama' => fake('id_ID')->name(),
                'username' => 'operator',
                'password' => Hash::make('password123'),
                'nomor_hp' => '081234567890',
                'alamat' => 'Pekanbaru',
                'role' => 'operator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_jabatan' => 'KS',
                'kode_golongan' => 'IIA',
                'kode_status_pegawai' => 'PNS',
                'nip' => '19800202',
                'nama' => fake('id_ID')->name(),
                'username' => 'kepsek',
                'password' => Hash::make('password123'),
                'nomor_hp' => '082345678901',
                'alamat' => 'Riau',
                'role' => 'kepala_sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
