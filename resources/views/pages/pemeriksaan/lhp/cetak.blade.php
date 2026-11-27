<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Print PHP</title>

    <style>
        @page {
            size: 330mm 210mm;
            margin: 15mm;
        }

        table {
            text-transform: uppercase;
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
            <td>
                @forelse($lhp->objekPemeriksaans as $item)
                    {{ $item->nama_objek }}

                    @if (!$loop->last)
                        <br>
                    @endif

                @empty

                    -
                @endforelse
            </td>
        </tr>

    </table>

    <br>

    <table>

        <thead>

            <tr>

                <th width="1%" style="text-align:center;">No</th>

                <th width="18%">
                    Temuan / Penyebab
                </th>

                <th width="18%">
                    Rekomendasi
                </th>

                <th width="15%">
                    Tindak Lanjut
                </th>

                <th width="4%">
                    Status
                </th>

                <th width="5%">
                    Nama Validator
                </th>

                <th width="5%">
                    Keterangan
                </th>

            </tr>

        </thead>

        <tbody>

            @php
                $no = 1;
            @endphp


            @foreach ($lhp->temuans as $temuan)
                @php

                    $totalBarisTemuan = 0;

                    foreach ($temuan->rekomendasis as $rek) {
                        $jumlahTL = $rek->tindakLanjut->count();

                        $totalBarisTemuan += $jumlahTL > 0 ? $jumlahTL : 1;
                    }

                @endphp



                @foreach ($temuan->rekomendasis as $rekIndex => $rekomendasi)
                    @php

                        $tindakLanjuts = $rekomendasi->tindakLanjut->sortBy('created_at');

                        if ($tindakLanjuts->count() == 0) {
                            $tindakLanjuts = collect([null]);
                        }

                    @endphp



                    @foreach ($tindakLanjuts as $tlIndex => $tl)
                        <tr>


                            {{-- NOMOR TEMUAN --}}
                            @if ($rekIndex == 0 && $tlIndex == 0)
                                <td rowspan="{{ $totalBarisTemuan }}" align="center">
                                    {{ $no++ }}
                                </td>
                            @endif



                            {{-- TEMUAN --}}
                            @if ($rekIndex == 0 && $tlIndex == 0)
                                <td rowspan="{{ $totalBarisTemuan }}" class="nowrap">


                                    <small>
                                        {{ $temuan->created_at ? $temuan->created_at->format('d-m-Y') : '-' }}
                                    </small>

                                    <br>



                                    {{ $temuan->administrasi }}
                                    <br>
                                    <br>
                                    {{ $temuan->uraian_temuan }}



                                    {{-- FINANSIAL --}}
                                    @if ($temuan->detailFinansial->count())
                                        <br>

                                        <small>
                                            Dengan Rincian Temuan Finansial:
                                        </small>


                                        <table style="width:100%;border-collapse:collapse;font-size:9px">


                                            <tr>

                                                <th style="border:1px solid #000">
                                                    No
                                                </th>

                                                <th style="border:1px solid #000">
                                                    Nama
                                                </th>


                                                <th style="border:1px solid #000">
                                                    Nilai
                                                </th>

                                            </tr>


                                            @php
                                                $total = 0;
                                            @endphp


                                            @foreach ($temuan->detailFinansial as $detail)
                                                @php
                                                    $total += $detail->nilai_temuan;
                                                @endphp


                                                <tr>

                                                    <td style="border:1px solid #000">
                                                        {{ $loop->iteration }}
                                                    </td>


                                                    <td style="border:1px solid #000">

                                                        {{ $detail->nama_pihak }}

                                                    </td>


                                                    <td style="border:1px solid #000;text-align:right">

                                                        Rp {{ number_format($detail->nilai_temuan, 0, ',', '.') }}

                                                    </td>


                                                </tr>
                                            @endforeach


                                            <tr>

                                                <td colspan="2" style="border:1px solid #000;text-align:right">

                                                    <b>Total</b>

                                                </td>


                                                <td style="border:1px solid #000;text-align:right">

                                                    <b>
                                                        Rp {{ number_format($total, 0, ',', '.') }}
                                                    </b>

                                                </td>

                                            </tr>


                                        </table>
                                    @endif


                                </td>
                            @endif





                            {{-- REKOMENDASI --}}

                            @if ($tlIndex == 0)
                                <td rowspan="{{ $tindakLanjuts->count() }}" class="nowrap">


                                    <small>

                                        {{ $rekomendasi->created_at ? $rekomendasi->created_at->format('d-m-Y') : '-' }}

                                    </small>


                                    <br>


                                    {{ $rekomendasi->uraian_rekomendasi }}


                                </td>
                            @endif






                            {{-- TINDAK LANJUT --}}

                            <td>


                                @if ($tl)
                                    <small>
                                        Tanggal Validasi:
                                        {{ $tl->tanggal_validasi ? \Carbon\Carbon::parse($tl->tanggal_validasi)->translatedFormat('d F Y') : '-' }}
                                    </small>

                                    <br>

                                    {{ $tl->narasi ?? '-' }}
                                @else
                                    Belum ada tindak lanjut
                                @endif


                            </td>





                            {{-- STATUS --}}

                            @if ($tlIndex == 0)
                                <td rowspan="{{ $tindakLanjuts->count() }}" align="center">


                                    @php

                                        $status = $rekomendasi->tindakLanjut->sortByDesc('created_at')->first();

                                    @endphp


                                    {{ $status?->status?->nama_status ?? '-' }}


                                </td>
                            @endif





                            <td>

                                {{ $tl?->validator ?? '-' }}

                            </td>



                            <td>

                                {{ $tl?->keterangan ?? '-' }}

                            </td>



                        </tr>
                    @endforeach
                @endforeach
            @endforeach







        </tbody>

    </table>

    <br><br><br>
    <br><br><br>

    <table style="width:100%; border:none;">
        <tr>
            <td style="border:none;">

                <div style="width:50%; margin-left:auto; text-align:center;">

                    Ketapang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

                    <br><br>

                    Inspektur Kabupaten Ketapang,

                    <br><br><br><br><br><br>

                    <b>{{ $penandatangan->nama ?? '-' }}</b>

                    <br>

                    NIP. {{ $penandatangan->nip ?? '-' }}

                </div>

            </td>
        </tr>
    </table>

</body>

</html>
