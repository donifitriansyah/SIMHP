<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>
        Register LHP
    </title>


    <style>
        body {
            font-family: Arial;
            font-size: 12px;
        }


        table {

            width: 100%;
            border-collapse: collapse;

        }


        table th,
        table td {

            border: 1px solid #000;
            padding: 5px;

        }


        .text-center {

            text-align: center;

        }


        .text-right {

            text-align: right;

        }


        @media print {

            .no-print {

                display: none;

            }

        }
    </style>


</head>


<body>


    <button class="no-print" onclick="window.print()">

        Cetak

    </button>



    <h3 class="text-center">
        REGISTER LAPORAN HASIL PEMERIKSAAN (LHP)
    </h3>



    <table>


        <thead>

            <tr>

                <th>No</th>

                <th>No LHP</th>

                <th>Tim Pemeriksa</th>

                <th>No SPT</th>

                <th>Tgl SPT</th>

                <th>Tahun</th>

                <th>Objek Pemeriksaan</th>

                <th>Dana Diperiksa</th>

                <th>Anggaran Temuan</th>

                <th>Temuan</th>

                <th>Jenis Riksa</th>


            </tr>


        </thead>



        <tbody>


            @foreach ($lhps as $lhp)
                @php

                    $nilaiTemuan = $lhp->temuans->flatMap->detailFinansial->sum('nilai_temuan');

                @endphp


                <tr>


                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>


                    <td>
                        {{ $lhp->nomor_lhp }}
                    </td>


                    <td>
                        {{ $lhp->irban->nama_irban ?? '-' }}
                    </td>


                    <td>
                        {{ $lhp->nomor_spt }}
                    </td>


                    <td>
                        {{ \Carbon\Carbon::parse($lhp->tanggal_spt)->format('d-m-Y') }}
                    </td>


                    <td>
                        {{ \Carbon\Carbon::parse($lhp->tanggal_spt)->format('Y') }}
                    </td>


                    <td>
                        {{ $lhp->objek_pemeriksaan }}
                    </td>


                    <td class="text-right">

                        Rp {{ number_format($lhp->jumlah_dana_diawasi, 0, ',', '.') }}

                    </td>


                    <td class="text-right">

                        Rp {{ number_format($nilaiTemuan, 0, ',', '.') }}

                    </td>



                    <td>

                        @foreach ($lhp->temuans as $temuan)
                            - {{ $temuan->uraian_temuan }} <br>
                        @endforeach


                    </td>



                    <td>

                        {{ $lhp->jenis_pemeriksaan }}

                    </td>


                </tr>
            @endforeach


        </tbody>


    </table>



    <br><br>


    <table style="border:none;width:100%">

        <tr>


            <td style="width:60%;border:none">


            </td>


            <td class="text-center" style="border:none">


                Ketapang, {{ now()->translatedFormat('d F Y') }}


                <br>


                Inspektur Kabupaten Ketapang


                <br><br><br><br>


                <strong>
                    {{ $inspektur->nama ?? '' }}
                </strong>


                <br>


                NIP. {{ $inspektur->nip ?? '' }}


            </td>


        </tr>


    </table>



</body>

</html>
