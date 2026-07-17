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
        @if ($jenis == 'internal')
            <tr>
                <td>Instansi</td>
                <td>:</td>
                <td>{{ $lhp->auditee->nama_dinas ?? '-' }}</td>
            </tr>
        @endif
        @if ($jenis == 'eksternal')
            <tr>
                <td>Pejabat</td>
                <td>:</td>
                <td>{{ $lhp->nama_pejabat_eksternal ?? '-' }}</td>
            </tr>
        @endif
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
                        $tindakLanjuts = $rekomendasi->tindakLanjut->sortBy('created_at');

                        $jumlahTL = $tindakLanjuts->count();

                        // jika belum ada tindak lanjut
                        if ($jumlahTL == 0) {
                            $jumlahTL = 1;
                        }
                    @endphp


                    @if ($tindakLanjuts->count() > 0)
                        @foreach ($tindakLanjuts as $index => $tl)
                            <tr>

                                {{-- Nomor --}}
                                @if ($index == 0)
                                    <td rowspan="{{ $jumlahTL }}" align="center">
                                        {{ $no++ }}
                                    </td>
                                @endif


                                {{-- Temuan --}}
                                @if ($index == 0)
                                    <td rowspan="{{ $jumlahTL }}" class="">

                                        <small>

                                            {{ $temuan->created_at ? $temuan->created_at->format('d-m-Y') : '-' }}
                                        </small>
                                        <br>
                                        {{ $temuan->uraian_temuan }}

                                        <br>



                                    </td>
                                @endif


                                {{-- Rekomendasi --}}
                                @if ($index == 0)
                                    <td rowspan="{{ $jumlahTL }}" class="text-wrap">
                                        {{ $rekomendasi->uraian_rekomendasi }}
                                    </td>
                                @endif


                                {{-- Tindak lanjut --}}
                                <td class="">

                                    <small>
                                        Tanggal Validasi:
                                        {{ $tl->tanggal_validasi ? \Carbon\Carbon::parse($tl->tanggal_validasi)->translatedFormat('d F Y') : '-' }}
                                    </small>
                                    <br>

                                    {{ $tl->narasi ?? '-' }}



                                </td>

                                {{-- Status --}}
                                @if ($index == 0)
                                    <td rowspan="{{ $jumlahTL }}" align="center">

                                        @php
                                            $tlTerakhir = $rekomendasi->tindakLanjut->sortByDesc('created_at')->first();
                                        @endphp

                                        {{ $tlTerakhir->status->nama_status ?? '-' }}

                                    </td>
                                @endif


                                {{-- Validator --}}
                                <td>
                                    {{ $tl->validator ?? '-' }}
                                </td>


                                {{-- Keterangan --}}
                                <td>
                                    {{ $tl->keterangan ?? '-' }}
                                </td>


                            </tr>
                        @endforeach
                    @else
                        <tr>

                            <td align="center">
                                {{ $no++ }}
                            </td>


                            <td class="text-wrap">
                                {{ $temuan->uraian_temuan }}
                            </td>


                            <td class="text-wrap">
                                {{ $rekomendasi->uraian_rekomendasi }}
                            </td>


                            <td>
                                Belum ada tindak lanjut
                            </td>


                            <td>
                                -
                            </td>


                            <td>
                                -
                            </td>


                            <td>
                                -
                            </td>

                        </tr>
                    @endif
                @endforeach
            @endforeach

        </tbody>

    </table>

</body>

</html>
