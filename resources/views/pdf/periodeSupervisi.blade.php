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
        <h2>PEMERINTAH KABUPATEN KAMPAR</h2>
        <h3>DINAS PENDIDIKAN</h3>
        <h2>UPT SD Negeri 035 Tarai Bangun</h2>
        <p>Alamat: Jalan Suka Karya, Dusun II Tarab Mandiri, Desa Tarai Bangun, Kecamatan Tambang, Kabupaten Kampar,
            Provinsi Riau</p>
    </div>

    <!-- 🔥 JUDUL -->
    <div class="judul">
        {{-- @foreach ($data as $index => $daper)
            <h3>LAPORAN HASIL OBSERVASI KELAS PERIODE {{ $daper->nama_periode }} </h3>
        @endforeach --}}
        <h3>
            LAPORAN HASIL OBSERVASI KELAS PERIODE
            {{ $hasil->nama_periode }}
        </h3>
    </div>

    <table style="border:none; margin-bottom:20px;">
        <tr>
            <td style="border:none; width:120px;"><strong>Nama Guru</strong></td>
            <td style="border:none; width:10px;">:</td>
            <td style="border:none;">{{ $nama_guru }}</td>
        </tr>

        <tr>
            <td style="border:none;"><strong>NIP</strong></td>
            <td style="border:none;">:</td>
            <td style="border:none;">{{ $nip_guru }}</td>
        </tr>
    </table>

    <!-- 📊 TABEL -->
    <table style="margin-bottom:0px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori Penilaian</th>
                <th>Nilai</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($data as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        {{ $row->nama_kategori_penilaian }}
                    </td>

                    <td>
                        {{ number_format($row->nilai, 2) * 20 }}
                    </td>

                </tr>
            @endforeach
            {{--
            @foreach ($data as $index => $row)
                <tr>
                    <td colspan="2">Total Nilai</td>
                    <td>
                        {{number_format($row->nilai, 2) * 20 }}
                    </td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
    <table style="margin-top:20px">

        <tr>

            <td width="150">
                <strong>Tindak Lanjut</strong>
            </td>

            <td>
                :
                {{ $hasil->nama_tindak_lanjut }}
            </td>

        </tr>

    </table>



    <!-- ✍️ TANDA TANGAN -->
    <table class="ttd">
        <tr>
            <td style="width: 60%; border: none;"></td>
            <td style="width: 40%; border: none; text-align: center;">
                <p style="margin-bottom: -3px;">Mengetahui,</p>
                <span>Kepala Sekolah</span>
                <p style="margin-top: -2px;">Tarai Bangun,
                    {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
                <div style="height: 60px;"></div>

                <p>
                    <span style="font-weight: bold;padding-bottom:2px;">
                        Evi Yenti, S.Pd
                    </span>
                </p>

                <p style="margin-top: -10px;  font-weight: bold; border-top:1px solid #000;display:inline-block;">
                    NIP. 197005101993042001
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
