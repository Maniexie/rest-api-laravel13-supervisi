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

    // 🔥 SIMPAN JAWABAN
    $data = [];
    $totalNilai = 0;

    foreach ($request->jawaban as $item) {
        $totalNilai += $item['nilai'];

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

    DB::table('jawaban_supervisi')->insert($data);

    // 🔥 LOGIKA TINDAK LANJUT OTOMATIS (optional)
    if ($totalNilai <= 50) {
        $tindakLanjut = "Pembinaan Intensif";
    } elseif ($totalNilai <= 75) {
        $tindakLanjut = "Pembinaan Ringan";
    } else {
        $tindakLanjut = "Dipertahankan";
    }

    return response()->json([
        'success' => true,
        'total_nilai' => $totalNilai,
        'tindak_lanjut' => $tindakLanjut
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


public function listHasilSupervisiByGuru($id_guru)
{
    $data = DB::table('jawaban_supervisi')
        ->join(
            'jadwal_supervisi',
            'jadwal_supervisi.id_jadwal_supervisi',
            '=',
            'jawaban_supervisi.id_jadwal_supervisi'
        )
        ->where('jawaban_supervisi.id_guru', $id_guru)

        ->select(
            'jadwal_supervisi.id_jadwal_supervisi',
            'jadwal_supervisi.nama_periode',
            'jadwal_supervisi.tanggal_mulai',
            'jadwal_supervisi.tanggal_selesai',
            'jadwal_supervisi.id_kepala_sekolah',
            DB::raw('SUM(jawaban_supervisi.jawaban) as total_nilai')
        )

        ->groupBy(
            'jadwal_supervisi.id_jadwal_supervisi',
            'jadwal_supervisi.nama_periode',
            'jadwal_supervisi.tanggal_mulai',
            'jadwal_supervisi.tanggal_selesai',
            'jadwal_supervisi.id_kepala_sekolah'
        )

        ->orderBy('jadwal_supervisi.tanggal_mulai', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}


public function detailHasilSupervisiGurubyJadwal($id_jadwal, $id_guru)
{
    $data = DB::table('jawaban_supervisi')
        ->where('id_jadwal_supervisi', $id_jadwal)
        ->where('id_guru', $id_guru)
        ->select(
            'id_item_penilaian',
            'jawaban'
        )
        ->get();

    return response()->json([
        'data' => $data
    ]);
}

public function statistikSupervisiGuru($id_guru)
{
    $data = DB::table('jawaban_supervisi')
        ->join('jadwal_supervisi', 'jadwal_supervisi.id_jadwal_supervisi', '=', 'jawaban_supervisi.id_jadwal_supervisi')
        ->where('jawaban_supervisi.id_guru', $id_guru)

        ->select(
            'jadwal_supervisi.nama_periode',
            DB::raw('SUM(jawaban_supervisi.jawaban) as total_nilai')
        )

        ->groupBy('jadwal_supervisi.nama_periode')
        ->orderBy('jadwal_supervisi.tanggal_mulai', 'asc')
        ->get();

    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}




public function simpanHasilSupervisi(Request $request)
{
    $request->validate([
        'id_jadwal_supervisi' => 'required',
        'id_guru' => 'required',
        'nilai' => 'required',
        'kode_tindak_lanjut' => 'required',
    ]);

    $user = auth()->user();

    if (!$user) {
    return response()->json([
        'message' => 'Unauthorized'
            ], 401);
        }

   $data =  DB::table('hasil_supervisi')->insert([
        'id_jadwal_supervisi' => $request->id_jadwal_supervisi,
        'id_guru' => $request->id_guru,
        'id_kepala_sekolah' => $user->id_user,
        'nilai' => $request->nilai,
        'kode_tindak_lanjut' => $request->kode_tindak_lanjut,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json([
        'success' => true,
        'data' => $data

    ]);
}


}
