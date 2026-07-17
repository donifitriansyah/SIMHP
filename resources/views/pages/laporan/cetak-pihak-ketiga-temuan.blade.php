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
                <th>Nama Perusahaan</th>

                <th>Pimpinan</th>

                <th>Paket Pekerjaan</th>


                <th>Objek Pemeriksaan</th>

                <th>Jumlah Temuan</th>

                <th>Jumlah Rekomendasi</th>

            </tr>

        </thead>



        <tbody>


            @forelse($pihakKetiga as $item)


                <tr>


                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>

                        @foreach ($item->lhps as $lhp)
                            @if ($lhp->temuans->count() > 0)
                                {{ $lhp->nomor_lhp }}

                                @if (!$loop->last)
                                    <br>
                                @endif
                            @endif
                        @endforeach

                    </td>



                    <td>
                        {{ strtoupper($item->nama_perusahaan) }}
                    </td>



                    <td>
                        {{ $item->nama_pimpinan }}
                    </td>



                    <td>
                        {{ $item->paket_pekerjaan }}
                    </td>



                    <td>

                        @foreach ($item->lhps as $lhp)
                            @if ($lhp->temuans->count() > 0)
                                {{ $lhp->objek_pemeriksaan }}

                                @if (!$loop->last)
                                    <br>
                                @endif
                            @endif
                        @endforeach


                    </td>




                    <td align="center">


                        {{ $item->lhps->sum(function ($lhp) {
                            return $lhp->temuans->count();
                        }) }}


                    </td>



                    <td align="center">


                        {{ $item->lhps->sum(function ($lhp) {
                            return $lhp->temuans->sum(function ($temuan) {
                                return $temuan->rekomendasis->count();
                            });
                        }) }}


                    </td>


                </tr>



            @empty


                <tr>

                    <td colspan="8" align="center">

                        Tidak ada data

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
