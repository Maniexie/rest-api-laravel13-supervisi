<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JawabanSupervisiController extends Controller
{
public function simpanJawabanSupervisi(Request $request)
{
    $request->validate([
        'id_jadwal_supervisi' => 'required|integer',
        'id_guru' => 'required|integer',
        'jawaban' => 'required|array',
        'jawaban.*.id_item' => 'required|integer',
        'jawaban.*.nilai' => 'required|integer|min:1|max:5',
    ]);

    $user = auth()->user();

    if (!$user) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    // 🔥 CEK DUPLIKAT
    $cek = DB::table('jawaban_supervisi')
        ->where('id_guru', $request->id_guru)
        ->where('id_jadwal_supervisi', $request->id_jadwal_supervisi)
        ->exists();

    if ($cek) {
        return response()->json([
            'success' => false,
            'message' => 'Guru sudah disupervisi'
        ], 400);
    }

    $data = [];

    foreach ($request->jawaban as $item) {
        $data[] = [
            'id_jadwal_supervisi' => $request->id_jadwal_supervisi,
            'id_item_penilaian' => $item['id_item'],
            'id_kepala_sekolah' => $user->id_user,
            'id_guru' => $request->id_guru,
            'jawaban' => $item['nilai'],
            'tanggal_pengisian' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    try {
        DB::table('jawaban_supervisi')->insert($data);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }

    return response()->json([
        'success' => true,
        'message' => 'Berhasil disimpan'
    ]);
}

 public function getGuruByJadwalSupervisi($id_jadwal)
{
    $data = DB::table('users')
        ->where('role', 'guru') // 🔥 filter guru saja
        ->select(
            'users.id_user as id_guru',
            'users.nama',

            DB::raw("
                CASE
                    WHEN EXISTS (
                        SELECT 1 FROM jawaban_supervisi
                        WHERE jawaban_supervisi.id_guru = users.id_user
                        AND jawaban_supervisi.id_jadwal_supervisi = $id_jadwal
                    )
                    THEN 1 ELSE 0
                END as sudah_disupervisi
            ")
        )
        ->get();

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}
}
