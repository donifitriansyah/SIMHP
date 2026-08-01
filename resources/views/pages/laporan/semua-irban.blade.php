@extends('layouts.backend')


@section('content')


    <div class="container-fluid py-4">


        <form method="GET" id="formLaporan" action="{{ route('laporan.irban') }}" class="row g-3 mb-4">
            <div class="col-md-1">

                <label class="form-label">
                    Jenis Laporan
                </label>

                <select name="jenis_laporan" class="form-select">

                    <option value="">
                        Semua Jenis
                    </option>

                    <option value="LHP" {{ request('jenis_laporan') == 'LHP' ? 'selected' : '' }}>
                        LHP
                    </option>

                    <option value="LHA" {{ request('jenis_laporan') == 'LHA' ? 'selected' : '' }}>
                        LHA
                    </option>

                    <option value="LHE" {{ request('jenis_laporan') == 'LHE' ? 'selected' : '' }}>
                        LHE
                    </option>

                    <option value="LHR" {{ request('jenis_laporan') == 'LHR' ? 'selected' : '' }}>
                        LHR
                    </option>

                </select>

            </div>
            <div class="col-md-2">

                <label class="form-label">
                    Jenis Pemeriksaan
                </label>

                <select name="jenis" class="form-select" required>

                    <option value="">
                        -- Pilih Jenis --
                    </option>

                    <option value="internal" {{ request('jenis') == 'internal' ? 'selected' : '' }}>
                        Internal
                    </option>

                    <option value="eksternal" {{ request('jenis') == 'eksternal' ? 'selected' : '' }}>
                        Eksternal
                    </option>

                </select>

            </div>
            <div class="col-md-2">
                <label class="form-label">Wilayah Kerja (Irban)</label>

                <select name="irban_id" class="form-select">

                    <option value="">Semua Irban</option>

                    @foreach ($listIrban as $irban)
                        <option value="{{ $irban->id }}" {{ request('irban_id') == $irban->id ? 'selected' : '' }}>

                            {{ $irban->nama_irban }}

                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Tanggal Awal</label>

                <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Tanggal Akhir</label>

                <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
            </div>

            <div class="col-md-1 d-flex align-items-end">

                <button class="btn btn-primary w-100">
                    <i class="bi bi-search"></i>
                    Tampilkan
                </button>

            </div>

            <div class="col-md-1 d-flex align-items-end">

                <a href="{{ route('laporan.irban') }}" class="btn btn-secondary w-100">

                    Reset

                </a>

            </div>

            <div class="col-md-1 d-flex align-items-end">

                <button type="button" onclick="cetakLaporan()" class="btn btn-success w-100">

                    <i class="bi bi-printer"></i>
                    Cetak

                </button>

            </div>

        </form>


        @if (count($laporan))
            <div class="card shadow-sm">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-bold">
                        LAPORAN SELURUH WILAYAH IRBAN
                    </h5>

                </div>

                <div class="card-body table-responsive">

                    <table class="table table-bordered table-striped align-middle text-center">

                        <thead>

                            <tr>

                                <th rowspan="2">No</th>

                                <th rowspan="2">Wilayah Irban</th>

                                <th rowspan="2">Obrik</th>

                                <th rowspan="2">JML {{ request('jenis_laporan') ?: 'Laporan' }}</th>

                                <th colspan="2">
                                    LAPORAN HASIL PEMERIKSAAN
                                </th>

                                <th colspan="3">
                                    PERKEMBANGAN TINDAK LANJUT
                                </th>

                                <th colspan="3">
                                    KERUGIAN NEGARA / DAERAH
                                </th>

                                <th colspan="3">
                                    KEWAJIBAN SETOR PAJAK
                                </th>

                            </tr>

                            <tr>

                                <th>Temuan</th>
                                <th>Rekomendasi</th>

                                <th>S</th>
                                <th>D</th>
                                <th>B</th>

                                <th>Nilai</th>
                                <th>Disetor</th>
                                <th>Sisa</th>

                                <th>Nilai</th>
                                <th>Disetor</th>
                                <th>Sisa</th>

                            </tr>

                        </thead>

                        <tbody>

                            @php

                                $no = 1;

                                $totalLhp = 0;
                                $totalTemuan = 0;
                                $totalRekomendasi = 0;

                                $totalS = 0;
                                $totalD = 0;
                                $totalB = 0;

                                $totalKerugian = 0;
                                $totalDisetor = 0;
                                $totalSisa = 0;

                                $totalPajak = 0;
                                $totalPajakDisetor = 0;
                                $totalPajakSisa = 0;

                            @endphp


                            @foreach ($laporan as $dataIrban)
                                @if ($dataIrban['nihil'])
                                    <tr>

                                        <td>{{ $no++ }}</td>

                                        <td>
                                            {{ $dataIrban['wilayah'] }}
                                        </td>

                                        <td colspan="13" class="fw-bold text-center">

                                            NIHIL

                                        </td>

                                    </tr>
                                @else
                                    @foreach ($dataIrban['lhp'] as $item)
                                        @php

                                            $totalLhp++;

                                            $totalTemuan += $item['temuan'];

                                            $totalRekomendasi += $item['rekomendasi'];

                                            $totalS += $item['selesai'];

                                            $totalD += $item['dalam_proses'];

                                            $totalB += $item['belum'];

                                            $totalKerugian += $item['kerugian'];

                                            $totalDisetor += $item['disetor'];

                                            $totalSisa += $item['sisa'];

                                            $totalPajak += $item['pajak'];

                                            $totalPajakDisetor += $item['pajak_disetor'];

                                            $totalPajakSisa += $item['pajak_sisa'];

                                        @endphp


                                        <tr>

                                            <td>{{ $no++ }}</td>

                                            <td>
                                                {{ $dataIrban['wilayah'] }}
                                            </td>

                                            <td>{{ $item['obrik'] }}</td>

                                            <td>1</td>

                                            <td>{{ $item['temuan'] }}</td>

                                            <td>{{ $item['rekomendasi'] }}</td>

                                            <td>{{ $item['selesai'] }}</td>

                                            <td>{{ $item['dalam_proses'] }}</td>

                                            <td>{{ $item['belum'] }}</td>

                                            <td>Rp {{ number_format($item['kerugian'], 0, ',', '.') }}</td>

                                            <td>Rp {{ number_format($item['disetor'], 0, ',', '.') }}</td>

                                            <td>Rp {{ number_format($item['sisa'], 0, ',', '.') }}</td>

                                            <td>Rp {{ number_format($item['pajak'], 0, ',', '.') }}</td>

                                            <td>Rp {{ number_format($item['pajak_disetor'], 0, ',', '.') }}</td>

                                            <td>Rp {{ number_format($item['pajak_sisa'], 0, ',', '.') }}</td>

                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach

                        </tbody>

                        <tfoot class="table-secondary fw-bold">

                            <tr>

                                <td colspan="3">
                                    JUMLAH
                                </td>

                                <td>{{ $totalLhp }}</td>

                                <td>{{ $totalTemuan }}</td>

                                <td>{{ $totalRekomendasi }}</td>

                                <td>{{ $totalS }}</td>

                                <td>{{ $totalD }}</td>

                                <td>{{ $totalB }}</td>

                                <td>Rp {{ number_format($totalKerugian, 0, ',', '.') }}</td>

                                <td>Rp {{ number_format($totalDisetor, 0, ',', '.') }}</td>

                                <td>Rp {{ number_format($totalSisa, 0, ',', '.') }}</td>

                                <td>Rp {{ number_format($totalPajak, 0, ',', '.') }}</td>

                                <td>Rp {{ number_format($totalPajakDisetor, 0, ',', '.') }}</td>

                                <td>Rp {{ number_format($totalPajakSisa, 0, ',', '.') }}</td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>
        @endif




    </div>
    <style>
        table th {
            font-size: 12px;
            vertical-align: middle !important;
        }

        table td {
            font-size: 12px;
        }

        th {
            white-space: nowrap;
        }
    </style>

    <script>
        function cetakLaporan() {

            let irban = document.querySelector('[name="irban_id"]').value;

            let jenis = document.querySelector('[name="jenis"]').value;

            let jenisLaporan = document.querySelector('[name="jenis_laporan"]').value;

            let tanggalAwal = document.querySelector('[name="tanggal_awal"]').value;

            let tanggalAkhir = document.querySelector('[name="tanggal_akhir"]').value;


            if (!tanggalAwal) {
                alert('Silahkan pilih Tanggal Awal terlebih dahulu');
                return;
            }


            if (!tanggalAkhir) {
                alert('Silahkan pilih Tanggal Akhir terlebih dahulu');
                return;
            }


            let url;


            // Jika pilih Irban tertentu
            if (irban) {

                url = "{{ route('laporan.irban.cetak') }}";

            }
            // Jika semua Irban
            else {

                url = "{{ route('laporan.semua-irban.cetak') }}";

            }



            let params = [];


            if (jenis) {

                params.push(
                    "jenis=" + encodeURIComponent(jenis)
                );

            }


            if (jenisLaporan) {

                params.push(
                    "jenis_laporan=" + encodeURIComponent(jenisLaporan)
                );

            }


            if (irban) {

                params.push(
                    "irban_id=" + encodeURIComponent(irban)
                );

            }


            params.push(
                "tanggal_awal=" + encodeURIComponent(tanggalAwal)
            );


            params.push(
                "tanggal_akhir=" + encodeURIComponent(tanggalAkhir)
            );


            url += "?" + params.join("&");


            window.open(url, "_blank");

        }
    </script>


@endsection
