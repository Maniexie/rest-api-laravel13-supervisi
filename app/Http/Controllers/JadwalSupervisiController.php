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
    $data = JadwalSupervisi::orderBy('tanggal_mulai', 'desc')->get();

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}

public function editJadwalSupervisi(Request $request, $id)
{
    try {
        $jadwal = JadwalSupervisi::findOrFail($id);

        $jadwal->update([
            'nama_periode' => $request->nama_periode,
            'deskripsi' => $request->deskripsi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return response()->json([
            'success' => true,
            'data' => $jadwal
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function getDetailJadwalSupervisi($id)
{
    $data = JadwalSupervisi::find($id);

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}

public function deleteJadwalSupervisi($id)
{
    $jadwal = JadwalSupervisi::findOrFail($id);

    $jadwal->delete();

    return response()->json([
        'success' => true,
        'message' => 'Jadwal berhasil dihapus'
    ]);
}
}
