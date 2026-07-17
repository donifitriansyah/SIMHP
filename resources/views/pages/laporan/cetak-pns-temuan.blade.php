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

                @if ($jenis == 'internal')
            <tr>
                <th>No</th>
                <th>Nama PNS</th>
                <th>Jabatan</th>
                <th>Instansi</th>
                <th>Objek Pemeriksaan</th>
                <th>Jumlah Temuan</th>
            </tr>
        @else
            <tr>
                <th>No</th>
                <th>Nama Pejabat</th>
                <th>Instansi Pemeriksa</th>
                <th>Nomor LHP</th>
                <th>Objek Pemeriksaan</th>
                <th>Jumlah Temuan</th>
            </tr>
            @endif


            </tr>


        </thead>



        <tbody>



            @if ($jenis == 'internal')

                {{-- ========================= --}}
                {{-- CETAK INTERNAL --}}
                {{-- ========================= --}}

                @forelse($data as $item)
                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>


                        <td>
                            {{ strtoupper($item->nama) }}
                        </td>


                        <td>
                            {{ strtoupper($item->jenis_jabatan ?? '-') }}
                        </td>


                        <td>
                            {{ $item->auditee->nama_dinas ?? '-' }}
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


                        <td class="text-center">

                            {{ $item->lhps->sum(function ($lhp) {
                                return $lhp->temuans->count();
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
            @else
                {{-- ========================= --}}
                {{-- CETAK EKSTERNAL --}}
                {{-- ========================= --}}


                @forelse($data as $item)
                    <tr>


                        <td class="text-center">

                            {{ $loop->iteration }}

                        </td>


                        <td>

                            {{ strtoupper($item->nama_pejabat_eksternal ?? '-') }}

                        </td>


                        <td>

                            @switch($item->instansi_pemeriksa)
                                @case('Itprov')
                                    Inspektorat Provinsi
                                @break

                                @case('BPK RI')
                                    Badan Pemeriksa Keuangan Republik Indonesia
                                @break

                                @case('BPKP')
                                    Badan Pengawasan Keuangan dan Pembangunan
                                @break

                                @default
                                    -
                            @endswitch
                        </td>


                        <td>

                            {{ $item->nomor_lhp }}

                        </td>


                        <td>

                            {{ $item->objek_pemeriksaan }}

                        </td>


                        <td class="text-center">

                            {{ $item->temuans->count() }}

                        </td>





                    </tr>


                    @empty


                        <tr>

                            <td colspan="7" class="text-center">
                                Tidak ada data pejabat eksternal yang memiliki temuan.
                            </td>

                        </tr>
                    @endforelse


                @endif



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
