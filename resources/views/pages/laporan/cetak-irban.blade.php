<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Per Irban</title>

    <style>
        @page {
            size: 330mm 210mm;
            margin: 12mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 8px;
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


        .judul {
            text-align: center;
            margin-bottom: 20px;
        }


        .text-left {
            text-align: left;
        }


        .ttd {
            margin-top: 50px;
        }


        .ttd table,
        .ttd td {
            border: none;
        }


        .ttd td {
            width: 33%;
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





    @foreach ($laporan as $dataIrban)
        <h4>
            <h4>
                {{ strtoupper($dataIrban['wilayah']) }}
            </h4>

        </h4>



        <table>


            <thead>


                <tr>

                    <th rowspan="2">
                        No
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



                @if ($dataIrban['nihil'])
                    <tr>

                        <td colspan="14">

                            <b>
                                NIHIL
                            </b>

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
                                {{ $loop->iteration }}
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





                    <tr>


                        <td colspan="2">
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
                @endif


            </tbody>


        </table>


        <br><br>
    @endforeach





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

                @if (count($laporan) == 1)
                    <td>



                        <br><br>

                        {{ strtoupper($laporan[0]['wilayah']) }}

                        <br><br><br>

                        <div class="nama">
                            {{ strtoupper($irbanPenandatangan->nama_penandatangan) }}
                        </div>

                        {{ $irbanPenandatangan->jabatan_penandatangan }}

                        <br>

                        NIP. {{ $irbanPenandatangan->nip_penandatangan }}

                    </td>
                @endif



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
