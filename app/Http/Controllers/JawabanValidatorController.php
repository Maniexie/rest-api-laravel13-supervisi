<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JawabanValidatorController extends Controller
{
    //

    public function hitungAiken($id_item)
    {
        $jawaban = DB::table('jawaban_validator')
            ->where('id_item_penilaian', $id_item)
            ->pluck('jawaban');

        $n = $jawaban->count();

        if ($n == 0) {
            return null;
        }

        $lo = 1;
        $c = 5;

        $totalS = 0;

        foreach ($jawaban as $r) {
            $totalS += ($r - $lo);
        }

        $v = $totalS / ($n * ($c - 1));

        return round($v, 3);
    }

    public function validasiItem($id_item)
    {
        $v = $this->hitungAiken($id_item);

        if ($v === null) {
            return response()->json(['message' => 'Belum ada data']);
        }

        // Threshold (bisa kamu sesuaikan di skripsi)
        $status = $v >= 0.8 ? 'valid' : 'tidak_valid';

        DB::table('item_penilaian')
            ->where('id_item_penilaian', $id_item)
            ->update([
                'nilai_aiken' => $v,
                'status_validasi' => $status,
            ]);

        return response()->json([
            'nilai_aiken' => $v,
            'status' => $status,
        ]);
    }

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
}
