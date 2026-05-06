<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Supervisi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .kop {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop h2,
        .kop h3,
        .kop p {
            margin: 2px;
        }

        .judul {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        th,
        td {
            padding: 8px;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
        }

        .ttd td {
            border: none;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- 🔵 KOP SEKOLAH -->
    <div class="kop">
        <h2>PEMERINTAH KABUPATEN XXX</h2>
        <h3>DINAS PENDIDIKAN</h3>
        <h2>SMK NEGERI 1 CONTOH</h2>
        <p>Alamat: Jl. Pendidikan No. 123</p>
    </div>

    <!-- 🔥 JUDUL -->
    <div class="judul">
        <h3>LAPORAN HASIL SUPERVISI GURU</h3>
        <p>ID Guru: {{ $guruId }}</p>
    </div>

    <!-- 📊 TABEL -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Periode</th>
                <th>Nilai</th>
                <th>Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $row->nama_periode }}</td>
                    <td>{{ number_format($row->nilai, 2) }}</td>
                    <td>{{ $row->kode_tindak_lanjut }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ✍️ TANDA TANGAN -->
    <table class="ttd">
        <tr>
            <td></td>
            <td>
                <p>Mengetahui,</p>
                <p>Kepala Sekolah</p>
                <br><br><br>
                <p><b>(___________________)</b></p>
            </td>
        </tr>
    </table>

</body>

</html>
