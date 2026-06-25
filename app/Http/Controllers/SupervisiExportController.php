<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SupervisiExportController extends Controller
{
    public function download($guruId)
    {
        $data = DB::table('hasil_supervisi')
            ->join(
                'jadwal_supervisi',
                'hasil_supervisi.id_jadwal_supervisi',
                '=',
                'jadwal_supervisi.id_jadwal_supervisi'
            )
              ->leftJoin(
        'k_tindak_lanjut_hasil_supervisi',
        'hasil_supervisi.kode_tindak_lanjut',
        '=',
        'k_tindak_lanjut_hasil_supervisi.kode_tindak_lanjut'
    )
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Tidak ada data supervisi'
            ], 404);
        }

        $filename = "supervisi_guru_{$guruId}.csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // header
            fputcsv($file, ['Periode', 'Nilai', 'Tindak Lanjut']);

            foreach ($data as $row) {
                fputcsv($file, [
                    $row->nama_periode,
                    $row->nilai,
                    $row->kode_tindak_lanjut
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    public function downloadPdf($guruId)
{
    $guru = User::findOrFail($guruId);

    $data = DB::table('hasil_supervisi')
    ->join(
        'jadwal_supervisi',
        'hasil_supervisi.id_jadwal_supervisi',
        '=',
        'jadwal_supervisi.id_jadwal_supervisi'
    )
    ->leftJoin(
        'k_tindak_lanjut_hasil_supervisi',
        'hasil_supervisi.kode_tindak_lanjut',
        '=',
        'k_tindak_lanjut_hasil_supervisi.kode_tindak_lanjut'
    )
    ->select(
        'jadwal_supervisi.nama_periode',
        'hasil_supervisi.nilai',
        'hasil_supervisi.kode_tindak_lanjut',
        'k_tindak_lanjut_hasil_supervisi.nama_tindak_lanjut'
    )
    ->where('hasil_supervisi.id_guru', $guruId)
    ->get();

    if ($data->isEmpty()) {
        return response()->json([
            'message' => 'Tidak ada data supervisi'
        ], 404);
    }

    $nama_guru = $guru->nama;
    $nip_guru = $guru->nip;
    // 🔥 kirim ke view PDF
    $pdf = Pdf::loadView('pdf.supervisi', [
        'data' => $data,
        'guruId' => $guruId,
        'nama_guru' => $nama_guru,
        'nip_guru' => $nip_guru,


    ])->setPaper('A4', 'portrait');

    return $pdf->download("laporan_observasi_kelas_$nama_guru.pdf");
}
}
