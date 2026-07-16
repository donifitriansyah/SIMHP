<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>
        Laporan PNS Memiliki Temuan
    </title>


    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }


        body {

            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;

        }


        h3 {

            text-align: center;
            margin: 0;

        }


        .kop {

            text-align: center;
            margin-bottom: 20px;

        }


        table {

            width: 100%;
            border-collapse: collapse;

        }


        th,
        td {

            border: 1px solid #000;
            padding: 6px;

        }


        th {

            text-align: center;
            background: #eee;

        }


        .text-center {

            text-align: center;

        }


        .text-left {

            text-align: left;

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
            width: 50%;

        }


        .nama {

            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;

        }


        .no-print {

            margin-bottom: 20px;

        }


        @media print {

            .no-print {

                display: none;

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



    <div class="kop">


        <h3>
            LAPORAN DAFTAR PNS YANG MEMILIKI TEMUAN PEMERIKSAAN
        </h3>


        <h3>
            INSPEKTORAT KABUPATEN KETAPANG
        </h3>


        <br>


        <h3>
            TAHUN PEMERIKSAAN {{ date('Y') }}
        </h3>


    </div>





    <table>


        <thead>

            <tr>

                <th width="5%">
                    No
                </th>


                <th>
                    Nama PNS
                </th>


                <th>
                    Jenis Jabatan
                </th>


                <th>
                    Instansi
                </th>


                <th>
                    Objek Pemeriksaan
                </th>


                <th>
                    Jumlah Temuan
                </th>


                <th>
                    Jumlah Rekomendasi
                </th>


            </tr>


        </thead>



        <tbody>



            @forelse($pegawai as $item)


                <tr>


                    <td class="text-center">

                        {{ $loop->iteration }}

                    </td>



                    <td>

                        {{ strtoupper($item->nama) }}

                    </td>



                    <td class="text-center">

                        {{ strtoupper($item->jenis_jabatan) }}

                    </td>



                    <td>

                        {{ $item->auditee->nama_dinas ?? '-' }}

                    </td>


                    <td>

                        @php
                            $lhpDenganTemuan = $item->lhps->filter(function ($lhp) {
                                return $lhp->temuans->count() > 0;
                            });
                        @endphp


                        @foreach ($lhpDenganTemuan as $lhp)
                            {{ $lhp->objek_pemeriksaan }}

                            @if (!$loop->last)
                                <br>
                            @endif
                        @endforeach


                    </td>



                    <td class="text-center">


                        {{ $item->lhps->sum(function ($lhp) {
                            return $lhp->temuans->count();
                        }) }}


                    </td>



                    <td class="text-center">


                        {{ $item->lhps->sum(function ($lhp) {
                            return $lhp->temuans->sum(function ($temuan) {
                                return $temuan->rekomendasis->count();
                            });
                        }) }}


                    </td>



                </tr>



            @empty


                <tr>

                    <td colspan="7" class="text-center">

                        Tidak ada data PNS yang memiliki temuan.

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

                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}


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
