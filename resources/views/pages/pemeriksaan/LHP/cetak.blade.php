<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Print LHP</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .table-info td {
            border: none;
            padding: 3px;
        }

        thead th {
            background: #f2f2f2;
            text-align: center;
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

                        <td align="center">
                            {{ $no++ }}
                        </td>

                        <td>
                            {{ $temuan->uraian_temuan }}
                        </td>

                        <td>

                            {{ $rekomendasi->uraian_rekomendasi }}

                        </td>

                        <td>

                            {{ $tl->narasi ?? '-' }}

                        </td>

                        <td align="center">

                            {{ $tl->status->nama_status ?? '-' }}

                        </td>

                        <td>

                            {{ $tl->validator ?? '-' }}

                        </td>

                        <td>

                            {{ $tl->keterangan ?? '-' }}

                        </td>

                    </tr>
                @endforeach
            @endforeach

        </tbody>

    </table>

</body>

</html>
