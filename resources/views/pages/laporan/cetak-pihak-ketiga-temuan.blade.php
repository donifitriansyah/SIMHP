<!DOCTYPE html>
<html>

<head>

    <title>
        Laporan Pihak Ketiga Temuan
    </title>


    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }


        body {

            font-family: Arial;
            font-size: 12px;

        }


        h3 {

            text-align: center;

        }


        table {

            width: 100%;
            border-collapse: collapse;

        }


        th,
        td {

            border: 1px solid black;
            padding: 5px;

        }


        th {

            background: #eee;
            text-align: center;

        }


        .ttd {

            margin-top: 50px;

        }


        .ttd table {

            border: none;

        }


        .ttd td {

            border: none;
            text-align: center;

        }


        .nama {

            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;

        }
    </style>


</head>


<body>


    <div style="text-align:center">


        <h3>
            LAPORAN PIHAK KETIGA YANG MEMILIKI TEMUAN
        </h3>


        <h3>
            INSPEKTORAT KABUPATEN KETAPANG
        </h3>


    </div>




    <table>


        <thead>

            <tr>

                <th>No</th>

                <th>No LHP</th>

                <th>Nama Penyedia</th>

                <th>Objek Pemeriksaan</th>

                <th>Jumlah Temuan</th>

                <th>Nilai Temuan</th>


            </tr>

        </thead>



        <tbody>


            @php

                $penyedia = $detail->groupBy('nama_penyedia');

            @endphp



            @forelse($penyedia as $nama => $items)


                <tr>


                    <td align="center">

                        {{ $loop->iteration }}

                    </td>



                    <td>


                        @foreach ($items as $item)
                            {{ $item->temuan->lhp->nomor_lhp }}


                            @if (!$loop->last)
                                <br>
                            @endif
                        @endforeach


                    </td>



                    <td>

                        {{ strtoupper($nama) }}

                    </td>



                    <td>


                        @foreach ($items as $item)
                            {{ $item->temuan->lhp->objek_pemeriksaan }}


                            @if (!$loop->last)
                                <br>
                            @endif
                        @endforeach


                    </td>



                    <td align="center">

                        {{ $items->count() }}

                    </td>



                    <td align="right">


                        Rp {{ number_format($items->sum('nilai_temuan'), 0, ',', '.') }}


                    </td>



                </tr>



            @empty


                <tr>

                    <td colspan="6" align="center">

                        Tidak ada data temuan pihak ketiga

                    </td>

                </tr>


            @endforelse



        </tbody>


    </table>




    <div class="ttd">


        <table>


            <tr>


                <td>

                    Mengetahui,

                    <br><br>

                    INSPEKTUR KABUPATEN KETAPANG


                    <div class="nama">

                        {{ strtoupper($inspektur->nama ?? '........................') }}

                    </div>


                    {{ $inspektur->golongan ?? '' }}

                    <br>

                    NIP.
                    {{ $inspektur->nip ?? '........................' }}


                </td>




                <td>


                    Ketapang,

                    {{ now()->translatedFormat('d F Y') }}


                    <br><br>

                    SEKRETARIS


                    <div class="nama">

                        {{ strtoupper($sekretaris->nama ?? '........................') }}

                    </div>


                    {{ $sekretaris->golongan ?? '' }}

                    <br>

                    NIP.
                    {{ $sekretaris->nip ?? '........................' }}


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
