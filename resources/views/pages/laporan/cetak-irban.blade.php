<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Per Irban</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        body {

            font-family: Arial, Helvetica, sans-serif;

            font-size: 11px;

        }

        h3 {

            text-align: center;

            margin-bottom: 5px;

        }

        h4 {

            text-align: center;

            margin-top: 0;

            margin-bottom: 20px;

        }

        table {

            width: 100%;

            border-collapse: collapse;

        }

        th,
        td {

            border: 1px solid #000;

            padding: 4px;

            text-align: center;

        }

        th {

            background: #eee;

        }

        .text-left {

            text-align: left;

        }

        @media print {

            .no-print {

                display: none;

            }

        }

        .kop {
            text-align: center;
            margin-bottom: 15px;
        }

        .kop h2 {
            margin: 0;
            font-size: 16px;
        }

        .kop h3 {
            margin: 0;
            font-size: 14px;
        }

        .kop p {
            margin: 2px;
            font-size: 11px;
        }


        .judul {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .judul h4 {
            margin: 3px;
        }


        .keterangan {
            margin-top: 20px;
            font-size: 10px;
        }


        .ttd {
            margin-top: 40px;
            width: 100%;
        }


        .ttd table {
            border: none;
        }


        .ttd td {
            border: none;
            text-align: center;
            width: 33%;
        }


        .nama {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }


        .no-border td {
            border: none;
        }

        .info-laporan h4 {
            text-align: left;
        }

        .info-laporan p {
            margin: 0;
            font-size: 12px;
        }
    </style>

</head>

<body>


    <div class="no-print" style="margin-bottom:20px">

        <button onclick="window.print()">
            🖨 Cetak
        </button>

    </div>

    <!-- JUDUL -->

    <div class="judul">

        <h4>
            LAPORAN BULANAN HASIL PEMERIKSAAN APIP
        </h4>

        <h4>
            INSPEKTORAT KABUPATEN KETAPANG
        </h4>


        <h4>
            TAHUN PEMERIKSAAN {{ $tahun ?? '-' }}
        </h4>


        <div class="info-laporan mt-2">

            <h4>
                KEADAAN BULAN {{ strtoupper($bulan) }} TAHUN {{ $tahun }}
            </h4>

            <h4>
                {{ strtoupper($laporan['wilayah'] ?? '') }}
            </h4>

        </div>


    </div>

    <table>

        <thead>

            <tr>

                <th rowspan="2">No</th>

                <th rowspan="2">Obrik</th>

                <th rowspan="2">JML LHP</th>

                <th colspan="2">LAPORAN HASIL PEMERIKSAAN</th>

                <th colspan="3">PERKEMBANGAN TINDAK LANJUT</th>

                <th colspan="3">KERUGIAN NEGARA / DAERAH</th>

                <th colspan="3">KEWAJIBAN SETOR PAJAK</th>

            </tr>

            <tr>

                <th>Temuan</th>

                <th>Rekomendasi</th>

                <th>S</th>

                <th>D</th>

                <th>B</th>

                <th>Nilai</th>

                <th>Disetor</th>

                <th>Sisa</th>

                <th>Nilai</th>

                <th>Disetor</th>

                <th>Sisa</th>

            </tr>

        </thead>

        <tbody>

            @if ($laporan['nihil'])

                <tr>
                    <td colspan="14">
                        <b>NIHIL</b>
                    </td>
                </tr>
            @else
                @php

                    $totalLhp = 0;
                    $totalTemuan = 0;
                    $totalRekomendasi = 0;

                    $totalSelesai = 0;
                    $totalProses = 0;
                    $totalBelum = 0;

                    $totalKerugian = 0;
                    $totalDisetor = 0;
                    $totalSisa = 0;

                    $totalPajak = 0;
                    $totalPajakDisetor = 0;
                    $totalPajakSisa = 0;

                @endphp


                @foreach ($laporan['lhp'] as $item)
                    @php

                        $totalLhp += 1;

                        $totalTemuan += $item['temuan'];

                        $totalRekomendasi += $item['rekomendasi'];

                        $totalSelesai += $item['selesai'];

                        $totalProses += $item['dalam_proses'];

                        $totalBelum += $item['belum'];

                        $totalKerugian += $item['kerugian'];

                        $totalDisetor += $item['disetor'];

                        $totalSisa += $item['sisa'];

                        $totalPajak += $item['pajak_nilai'] ?? 0;

                        $totalPajakDisetor += $item['pajak_disetor'] ?? 0;

                        $totalPajakSisa += $item['pajak_sisa'] ?? 0;

                    @endphp


                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td class="text-left">
                            {{ $item['obrik'] }}
                        </td>

                        <td>
                            1
                        </td>

                        <td>
                            {{ $item['temuan'] }}
                        </td>

                        <td>
                            {{ $item['rekomendasi'] }}
                        </td>

                        <td>
                            {{ $item['selesai'] }}
                        </td>

                        <td>
                            {{ $item['dalam_proses'] }}
                        </td>

                        <td>
                            {{ $item['belum'] }}
                        </td>


                        <td>
                            Rp {{ number_format($item['kerugian'], 0, ',', '.') }}
                        </td>

                        <td>
                            Rp {{ number_format($item['disetor'], 0, ',', '.') }}
                        </td>

                        <td>
                            Rp {{ number_format($item['sisa'], 0, ',', '.') }}
                        </td>


                        <td>
                            Rp {{ number_format($item['pajak_nilai'] ?? 0, 0, ',', '.') }}
                        </td>

                        <td>
                            Rp {{ number_format($item['pajak_disetor'] ?? 0, 0, ',', '.') }}
                        </td>

                        <td>
                            Rp {{ number_format($item['pajak_sisa'] ?? 0, 0, ',', '.') }}
                        </td>


                    </tr>
                @endforeach



                <tr class="fw-bold">

                    <td colspan="2">
                        JUMLAH
                    </td>


                    <td>
                        {{ $totalLhp }}
                    </td>


                    <td>
                        {{ $totalTemuan }}
                    </td>


                    <td>
                        {{ $totalRekomendasi }}
                    </td>


                    <td>
                        {{ $totalSelesai }}
                    </td>


                    <td>
                        {{ $totalProses }}
                    </td>


                    <td>
                        {{ $totalBelum }}
                    </td>


                    <td>
                        Rp {{ number_format($totalKerugian, 0, ',', '.') }}
                    </td>


                    <td>
                        Rp {{ number_format($totalDisetor, 0, ',', '.') }}
                    </td>


                    <td>
                        Rp {{ number_format($totalSisa, 0, ',', '.') }}
                    </td>


                    <td>
                        Rp {{ number_format($totalPajak, 0, ',', '.') }}
                    </td>


                    <td>
                        Rp {{ number_format($totalPajakDisetor, 0, ',', '.') }}
                    </td>


                    <td>
                        Rp {{ number_format($totalPajakSisa, 0, ',', '.') }}
                    </td>


                </tr>


            @endif


        </tbody>

    </table>


    <div class="keterangan">

        <b>Keterangan :</b>

        <br>

        S = Selesai

        <br>

        D = Dalam Proses

        <br>

        B = Belum Ditindaklanjuti


    </div>

    <div class="ttd">

        <table class="no-border">

            <tr>

                {{-- KIRI --}}
                <td class="text-center">

                    Menyetujui,

                    <br><br>

                    {{ strtoupper($laporan['wilayah'] ?? '') }}


                    <br><br><br><br>


                    <div class="nama">
                        {{ $irban ?? '........................' }}
                    </div>


                    NIP. ..............................

                </td>



                {{-- TENGAH --}}
                <td class="text-center">

                    Mengetahui,

                    <br><br>

                    INSPEKTUR KABUPATEN KETAPANG


                    <br><br><br><br>


                    <div class="nama">
                        {{ $inspektur ?? '........................' }}
                    </div>


                    NIP. ..............................

                </td>




                {{-- KANAN --}}
                <td class="text-center">


                    Ketapang,
                    {{ \Carbon\Carbon::parse($tanggal_cetak ?? now())->translatedFormat('d F Y') }}


                    <br><br>


                    SEKRETARIS


                    <br><br><br><br>


                    <div class="nama">
                        {{ $sekretaris ?? '........................' }}
                    </div>


                    NIP. ..............................

                </td>


            </tr>


        </table>


    </div>

    <script>
        window.onload = function() {

            window.print();

        }
    </script>

</body>

</html>
