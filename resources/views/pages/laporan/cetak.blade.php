<!DOCTYPE html>
<html>

<head>

    <title>
        Laporan Tindak Lanjut LHP
    </title>


    <style>
        @page {
            size: A4 landscape;
            margin: 8mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
        }

        h4 {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px;
            vertical-align: middle;
        }

        th {
            background: #ececec;
            text-align: center;
        }

        .text-start {
            text-align: left;
        }

        tfoot {
            font-weight: bold;
        }
    </style>



</head>


<body onload="window.print()">



    <h4 style="text-align:center">

        REKAP PERKEMBANGAN TINDAK LANJUT LHP

    </h4>



    <table class="table table-bordered table-sm text-center align-middle laporan-table">


        <thead class="table-light">


            <tr>


                <th rowspan="2">
                    No
                </th>


                <th rowspan="2">
                    Wilayah Kerja
                </th>


                <th rowspan="2">
                    JML LHP
                </th>



                <th colspan="2">
                    JUMLAH
                </th>



                <th colspan="6">
                    PERKEMBANGAN TINDAK LANJUT
                </th>



                <th colspan="5">
                    Kerugian Negara / Daerah
                </th>



                <th colspan="5">
                    Kewajiban Setor Pajak Kepada Negara / Daerah
                </th>


            </tr>



            <tr>


                <th>
                    T
                </th>


                <th>
                    R
                </th>



                <th>
                    S
                </th>

                <th>
                    %
                </th>


                <th>
                    D
                </th>

                <th>
                    %
                </th>



                <th>
                    B
                </th>


                <th>
                    %
                </th>



                <th>
                    Nilai Rp
                </th>


                <th>
                    Disetor Rp
                </th>


                <th>
                    %
                </th>


                <th>
                    Sisa
                </th>


                <th>
                    %
                </th>




                <th>
                    Nilai
                </th>


                <th>
                    Disetor
                </th>


                <th>
                    %
                </th>


                <th>
                    Sisa
                </th>


                <th>
                    %
                </th>



            </tr>


        </thead>




        <tbody>



            @php

                $total = [
                    'lhp' => 0,
                    'temuan' => 0,
                    'rekomendasi' => 0,
                    'selesai' => 0,
                    'proses' => 0,
                    'belum' => 0,
                    'kerugian' => 0,
                    'disetor' => 0,
                    'sisa_kerugian' => 0,
                    'pajak' => 0,
                    'pajak_disetor' => 0,
                    'sisa_pajak' => 0,
                ];

            @endphp




            @foreach ($laporan as $item)
                @php

                    $total['lhp'] += $item['lhp'];

                    $total['temuan'] += $item['temuan'];

                    $total['rekomendasi'] += $item['rekomendasi'];

                    $total['selesai'] += $item['selesai'];

                    $total['proses'] += $item['dalam_proses'];

                    $total['belum'] += $item['belum'];

                    $total['kerugian'] += $item['kerugian'];

                    $total['disetor'] += $item['disetor'];

                    $total['sisa_kerugian'] += $item['sisa_kerugian'];

                    $total['pajak'] += $item['pajak'];

                    $total['pajak_disetor'] += $item['pajak_disetor'];

                    $total['sisa_pajak'] += $item['sisa_pajak'];

                @endphp



                <tr>


                    <td>
                        {{ $loop->iteration }}
                    </td>


                    <td class="text-start">

                        {{ $item['wilayah'] }}

                    </td>



                    <td>

                        {{ $item['lhp'] }}

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

                        {{ $item['persen_selesai'] }} %

                    </td>




                    <td>

                        {{ $item['dalam_proses'] }}

                    </td>


                    <td>

                        {{ $item['persen_proses'] }} %

                    </td>




                    <td>

                        {{ $item['belum'] }}

                    </td>


                    <td>

                        {{ $item['persen_belum'] }} %

                    </td>





                    {{-- Kerugian --}}

                    <td>

                        Rp {{ number_format($item['kerugian'], 0, ',', '.') }}

                    </td>


                    <td>

                        Rp {{ number_format($item['disetor'], 0, ',', '.') }}

                    </td>


                    <td>

                        {{ $item['persen_kerugian'] }} %

                    </td>


                    <td>

                        Rp {{ number_format($item['sisa_kerugian'], 0, ',', '.') }}

                    </td>


                    <td>

                        {{ $item['kerugian'] > 0 ? round(($item['sisa_kerugian'] / $item['kerugian']) * 100, 2) : 0 }}
                        %

                    </td>






                    {{-- Pajak --}}


                    <td>

                        Rp {{ number_format($item['pajak'], 0, ',', '.') }}

                    </td>



                    <td>

                        Rp {{ number_format($item['pajak_disetor'], 0, ',', '.') }}

                    </td>



                    <td>

                        {{ $item['persen_pajak'] }} %

                    </td>



                    <td>

                        Rp {{ number_format($item['sisa_pajak'], 0, ',', '.') }}

                    </td>



                    <td>

                        {{ $item['pajak'] > 0 ? round(($item['sisa_pajak'] / $item['pajak']) * 100, 2) : 0 }}
                        %

                    </td>



                </tr>
            @endforeach



        </tbody>





        <tfoot class="table-light fw-bold">


            <tr>


                <td colspan="2">
                    Jumlah Keseluruhan
                </td>


                <td>
                    {{ $total['lhp'] }}
                </td>


                <td>
                    {{ $total['temuan'] }}
                </td>


                <td>
                    {{ $total['rekomendasi'] }}
                </td>


                <td>
                    {{ $total['selesai'] }}
                </td>


                <td>
                    {{ $total['rekomendasi'] > 0 ? round(($total['selesai'] / $total['rekomendasi']) * 100, 2) : 0 }}
                    %
                </td>


                <td>
                    {{ $total['proses'] }}
                </td>


                <td>
                    {{ $total['rekomendasi'] > 0 ? round(($total['proses'] / $total['rekomendasi']) * 100, 2) : 0 }}
                    %
                </td>


                <td>
                    {{ $total['belum'] }}
                </td>


                <td>
                    {{ $total['rekomendasi'] > 0 ? round(($total['belum'] / $total['rekomendasi']) * 100, 2) : 0 }}
                    %
                </td>


                <td>
                    Rp {{ number_format($total['kerugian'], 0, ',', '.') }}
                </td>


                <td>
                    Rp {{ number_format($total['disetor'], 0, ',', '.') }}
                </td>

                <td>
                    {{ $total['kerugian'] > 0 ? round(($total['disetor'] / $total['kerugian']) * 100, 2) : 0 }}
                    %
                </td>


                <td>
                    Rp {{ number_format($total['sisa_kerugian'], 0, ',', '.') }}
                </td>


                <td>
                    {{ $total['kerugian'] > 0 ? round(($total['sisa_kerugian'] / $total['kerugian']) * 100, 2) : 0 }}
                    %
                </td>



                <td>
                    Rp {{ number_format($total['pajak'], 0, ',', '.') }}
                </td>


                <td>
                    Rp {{ number_format($total['pajak_disetor'], 0, ',', '.') }}
                </td>


                <td>
                    {{ $total['pajak'] > 0 ? round(($total['pajak_disetor'] / $total['pajak']) * 100, 2) : 0 }}
                    %
                </td>


                <td>
                    Rp {{ number_format($total['sisa_pajak'], 0, ',', '.') }}
                </td>


                <td>
                    {{ $total['pajak'] > 0 ? round(($total['sisa_pajak'] / $total['pajak']) * 100, 2) : 0 }}
                    %
                </td>



            </tr>


        </tfoot>


    </table>



</body>

</html>
