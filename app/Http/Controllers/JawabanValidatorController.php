<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                'status_validasi' => $status
            ]);

        return response()->json([
            'nilai_aiken' => $v,
            'status' => $status
        ]);
    }
}
