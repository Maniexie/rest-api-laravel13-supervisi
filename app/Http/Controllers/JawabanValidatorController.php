<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JawabanValidatorController extends Controller
{


// ====== MENYIMPAN JAWABAN VALIDATOR MELALUI KUESIONER ======
    public function postJawabanValidator(Request $request)
    {
     $request->validate([
        'versi' => 'required|integer',
        'jawaban' => 'required|array',
        'jawaban.*.id_item_penilaian' => 'required|integer',
        'jawaban.*.jawaban' => 'required|integer|min:1|max:7',
    ]);

    DB::beginTransaction();

    try {
        $idValidator = Auth::id(); // 🔥 dari login

            $exists = DB::table('jawaban_validator')
            ->where('versi', $request->versi)
            ->where('id_validator', $idValidator)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengisi kuesioner ini'
            ], 400);
        }


        $dataInsert = [];

        foreach ($request->jawaban as $item) {
            $dataInsert[] = [
                'id_item_penilaian' => $item['id_item_penilaian'],
                'id_validator' => $idValidator,
                'jawaban' => $item['jawaban'],
                'versi' => $request->versi,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('jawaban_validator')->insert($dataInsert);

        // setelah insert
        $this->cekDanHitung($request->versi);
        DB::commit();


        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil disimpan',
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
    }


    /// =================================================================================================


    //  ======= STATUS PENGUJIAN UNTUK VALIDASI KUESIONER ========
    public function statusPengujian()
    {
        $idValidator = Auth::id(); // 🔥 dari login

      $versi = DB::table('jawaban_validator')
        ->where('id_validator', $idValidator)
        ->pluck('versi')   // 🔥 ambil versi saja
        ->unique()         // 🔥 hilangkan duplikat
        ->values();        // 🔥 reset index

        if ($versi->count() > 0) {
              return response()->json([
        'success' => true,
        'data' => $versi
    ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum mengisi kuesioner ini'
            ], 200);
        }
    }
// =================================================================================================

    //  ======= MENGUBAH DATA ITEM PENILAIAN ========
      public function cekDanHitung($versi)
{
    $minimalValidator = 5; // 🔥 bisa kamu ubah sesuai skripsi

    $jumlahValidator = DB::table('jawaban_validator')
        ->where('versi', $versi)
        ->distinct('id_validator')
        ->count('id_validator');

    if ($jumlahValidator >= $minimalValidator) {
        $this->hitungAikenPerVersi($versi);
    }
}

    public function hitungAikenPerVersi($versi)
{
    $items = DB::table('item_penilaian')
        ->where('versi', $versi)
        ->get();

    $lo = 1;
    $c = 7; // 🔥 sesuai skala kamu (1–7)

    foreach ($items as $item) {

        $jawaban = DB::table('jawaban_validator')
            ->where('id_item_penilaian', $item->id_item_penilaian)
            ->pluck('jawaban');

        $n = $jawaban->count();

        if ($n == 0) continue;

        $totalS = 0;

        foreach ($jawaban as $r) {
            $totalS += ($r - $lo);
        }

        $v = $totalS / ($n * ($c - 1));

        $status = $v >= 0.8 ? 'valid' : 'tidak_valid';

        DB::table('item_penilaian')
            ->where('id_item_penilaian', $item->id_item_penilaian)
            ->update([
                'nilai_aiken' => round($v,3),
                'status' => $status,
            ]);
    }

    return true;
}


 //  ===========================================================================



}
