<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Print LHP</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #000;
        }

        h3 {
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }


        table th,
        table td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
            line-height: 1.4;
        }


        .table-info {
            table-layout: auto;
        }


        .table-info td {
            border: none;
            padding: 2px;
        }


        thead th {
            background: #f2f2f2;
            text-align: center;
            vertical-align: middle;
        }


        tbody td {
            text-align: justify;
        }


        .text-wrap {
            white-space: pre-line;
        }


        tr {
            page-break-inside: avoid;
        }
    </style>

</head>

<body onload="window.print()">

    <h3>
        RINCIAN TEMUAN PEMERIKSAAN DAN TINDAK LANJUTNYA
    </h3>

    <table class="table-info">

        <tr>
            <td width="170">No. LHP</td>
            <td width="10">:</td>
            <td>{{ $lhp->nomor_lhp }}</td>
        </tr>
        <tr>
            <td width="170">Tanggal LHP</td>
            <td width="10">:</td>
            <td>{{ \Carbon\Carbon::parse($lhp->tanggal_lhp)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Instansi</td>
            <td>:</td>
            <td>{{ $lhp->auditee->nama_dinas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Objek Pemeriksaan</td>
            <td>:</td>
            <td>{{ $lhp->objek_pemeriksaan }}</td>
        </tr>

    </table>

    <br>

    <table>

        <thead>

            <tr>

                <th width="4%">No</th>

                <th width="18%">
                    Temuan / Penyebab
                </th>

                <th width="18%">
                    Rekomendasi
                </th>

                <th width="18%">
                    Tindak Lanjut
                </th>

                <th width="10%">
                    Status
                </th>

                <th width="15%">
                    Nama Validator
                </th>

                <th>
                    Keterangan
                </th>

            </tr>

        </thead>

        <tbody>

            @php
                $no = 1;
            @endphp

            @foreach ($lhp->temuans as $temuan)
                @foreach ($temuan->rekomendasis as $rekomendasi)
                    @php
                        $tl = $rekomendasi->tindakLanjut->sortByDesc('created_at')->first();
                    @endphp

                    <tr>

                        <td class="text-wrap" align="center">
                            {{ $no++ }}
                        </td>

                        <td class="text-wrap">
                            {{ $temuan->uraian_temuan }}
                        </td>

                        <td class="text-wrap">
                            {{ $rekomendasi->uraian_rekomendasi }}
                        </td>

                        <td class="text-wrap">
                            {{ $tl->narasi ?? '-' }}
                        </td>

                        <td class="text-wrap" align="center">

                            {{ $tl->status->nama_status ?? '-' }}

                        </td>

                        <td class="text-wrap">

                            {{ $tl->validator ?? '-' }}

                        </td>

                        <td class="text-wrap">

                            {{ $tl->keterangan ?? '-' }}

                        </td>

                    </tr>
                @endforeach
            @endforeach

        </tbody>

    </table>

</body>

</html>
