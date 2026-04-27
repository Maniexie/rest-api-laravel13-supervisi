<?php

namespace App\Http\Controllers;

use App\Models\JadwalSupervisi;
use Illuminate\Http\Request;

class JadwalSupervisiController extends Controller
{
   public function tambahJadwalSupervisi(Request $request)
{
    $request->validate([
        'nama_periode' => 'required',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date',
        'deskripsi' => 'required'
    ]);

    $jadwal = JadwalSupervisi::create([
        'id_kepala_sekolah' => auth()->id(),
        'nama_periode' => $request->nama_periode,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'deskripsi' => $request->deskripsi,
    ]);

    return response()->json([
        'success' => true,
        'data' => $jadwal
    ]);
}

public function getJadwalSupervisi()
{
   return response()->json(JadwalSupervisi::all());
}

}
