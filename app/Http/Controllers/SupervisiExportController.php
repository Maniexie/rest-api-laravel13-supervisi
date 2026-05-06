<?php

namespace App\Http\Controllers;

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
            ->select(
                'jadwal_supervisi.nama_periode',
                'hasil_supervisi.nilai',
                'hasil_supervisi.kode_tindak_lanjut'
            )
            ->where('hasil_supervisi.id_guru', $guruId)
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
    $data = DB::table('hasil_supervisi')
        ->join(
            'jadwal_supervisi',
            'hasil_supervisi.id_jadwal_supervisi',
            '=',
            'jadwal_supervisi.id_jadwal_supervisi'
        )
        ->select(
            'jadwal_supervisi.nama_periode',
            'hasil_supervisi.nilai',
            'hasil_supervisi.kode_tindak_lanjut'
        )
        ->where('hasil_supervisi.id_guru', $guruId)
        ->get();

    if ($data->isEmpty()) {
        return response()->json([
            'message' => 'Tidak ada data supervisi'
        ], 404);
    }

    // 🔥 kirim ke view PDF
    $pdf = Pdf::loadView('pdf.supervisi', [
        'data' => $data,
        'guruId' => $guruId
    ])->setPaper('A4', 'portrait');

    return $pdf->download("laporan_supervisi_guru_$guruId.pdf");
}
}
