<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Semua Irban</title>

    <style>
        @page {
            size: 330mm 210mm;
            margin: 12mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
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
            vertical-align: middle;
        }


        th {
            background: #eee;
        }


        .judul {
            text-align: center;
            margin-bottom: 20px;
        }


        .text-left {
            text-align: center;
        }


        .ttd {
            margin-top: 50px;
            width: 100%;
        }


        .ttd table {
            width: 100%;
            border: none;
        }


        .ttd td {
            border: none;
            width: 50%;
            text-align: center;
        }


        .nama {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }


        .no-print {
            margin-bottom: 20px;
        }


        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }

        }
    </style>

</head>


<body>


    <div class="no-print">

        <button onclick="window.print()">
            🖨 Cetak
        </button>

    </div>



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


        <h4>
            KEADAAN BULAN
            {{ strtoupper($bulan ?? '-') }}
            TAHUN
            {{ $tahun ?? '-' }}
        </h4>


    </div>



    <table>

        <thead>


            <tr>

                <th rowspan="2">
                    No
                </th>


                <th rowspan="2">
                    Irban
                </th>


                <th rowspan="2">
                    Obrik
                </th>


                <th rowspan="2">
                    JML LHP
                </th>


                <th colspan="2">
                    LAPORAN HASIL PEMERIKSAAN
                </th>


                <th colspan="3">
                    PERKEMBANGAN TINDAK LANJUT
                </th>


                <th colspan="3">
                    KERUGIAN NEGARA / DAERAH
                </th>


                <th colspan="3">
                    KEWAJIBAN SETOR PAJAK
                </th>


            </tr>



            <tr>


                <th>
                    Temuan
                </th>


                <th>
                    Rekomendasi
                </th>


                <th>
                    S
                </th>


                <th>
                    D
                </th>


                <th>
                    B
                </th>


                <th>
                    Nilai
                </th>


                <th>
                    Disetor
                </th>


                <th>
                    Sisa
                </th>


                <th>
                    Nilai
                </th>


                <th>
                    Disetor
                </th>


                <th>
                    Sisa
                </th>


            </tr>


        </thead>



        <tbody>


            @php

                $no = 1;

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



            @foreach ($laporan as $dataIrban)
                @if ($dataIrban['nihil'])
                    <tr>

                        <td>
                            {{ $no++ }}
                        </td>


                        <td>
                            {{ $dataIrban['wilayah'] }}
                        </td>


                        <td colspan="13">
                            <b>NIHIL</b>
                        </td>


                    </tr>
                @else
                    @foreach ($dataIrban['lhp'] as $item)
                        @php

                            $totalLhp++;

                            $totalTemuan += $item['temuan'];

                            $totalRekomendasi += $item['rekomendasi'];

                            $totalSelesai += $item['selesai'];

                            $totalProses += $item['dalam_proses'];

                            $totalBelum += $item['belum'];

                            $totalKerugian += $item['kerugian'];

                            $totalDisetor += $item['disetor'];

                            $totalSisa += $item['sisa'];

                            $totalPajak += $item['pajak'];

                            $totalPajakDisetor += $item['pajak_disetor'];

                            $totalPajakSisa += $item['pajak_sisa'];

                        @endphp



                        <tr>


                            <td>
                                {{ $no++ }}
                            </td>


                            <td class="text-left">
                                {{ $dataIrban['wilayah'] }}
                            </td>


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
                                Rp {{ number_format($item['pajak'], 0, ',', '.') }}
                            </td>


                            <td>
                                Rp {{ number_format($item['pajak_disetor'], 0, ',', '.') }}
                            </td>


                            <td>
                                Rp {{ number_format($item['pajak_sisa'], 0, ',', '.') }}
                            </td>


                        </tr>
                    @endforeach
                @endif
            @endforeach




            <tr>


                <td colspan="3">

                    <b>
                        JUMLAH
                    </b>

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



        </tbody>


    </table>





    <div class="ttd">


        <table>


            <tr>

                <td>

                    Mengetahui,

                    <br><br>

                    INSPEKTUR KABUPATEN KETAPANG

                    <br><br><br>


                    <div class="nama">

                        {{ strtoupper($inspektur->nama ?? '........................') }}

                    </div>


                    {{ $inspektur->golongan ?? '' }}

                    <br>

                    NIP. {{ $inspektur->nip ?? '........................' }}


                </td>



                <td>

                    Ketapang,

                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}


                    <br><br>

                    SEKRETARIS


                    <br><br><br>


                    <div class="nama">

                        {{ strtoupper($sekretaris->nama ?? '........................') }}

                    </div>


                    {{ $sekretaris->golongan ?? '' }}


                    <br>

                    NIP. {{ $sekretaris->nip ?? '........................' }}


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
