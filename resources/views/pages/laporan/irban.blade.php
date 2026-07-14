@extends('layouts.backend')


@section('content')


    <div class="container-fluid py-4">


        <form method="GET" id="formLaporan" action="{{ route('laporan.irban') }}" class="row g-3 mb-4">

            <div class="col-md-2">
                <label class="form-label">Wilayah Kerja (Irban)</label>

                <select name="irban_id" class="form-select" required>

                    <option value="">Pilih Irban</option>

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

            <div class="col-md-2 d-flex align-items-end">

                <button class="btn btn-primary w-100">
                    <i class="bi bi-search"></i>
                    Tampilkan
                </button>

            </div>

            <div class="col-md-2 d-flex align-items-end">

                <a href="{{ route('laporan.irban') }}" class="btn btn-secondary w-100">

                    Reset

                </a>

            </div>

            <div class="col-md-2 d-flex align-items-end">

                <button type="button" onclick="cetakLaporan()" class="btn btn-success w-100">

                    <i class="bi bi-printer"></i>
                    Cetak

                </button>

            </div>

        </form>



        @if ($laporan)


            <h5 class="mt-4">

                {{ $laporan['wilayah'] }}

            </h5>



            <table class="table table-bordered text-center align-middle">

                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Obrik</th>
                        <th rowspan="2">JML LHP</th>

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
                            KEWAJIBAN SETOR PAJAK KEPADA NEGARA / DAERAH
                        </th>
                    </tr>

                    <tr>

                        <th>TEMUAN</th>
                        <th>REKOMENDASI</th>

                        <th>S</th>
                        <th>D</th>
                        <th>B</th>

                        <th>NILAI</th>
                        <th>DISETOR</th>
                        <th>SISA</th>

                        <th>NILAI</th>
                        <th>DISETOR</th>
                        <th>SISA</th>

                    </tr>

                </thead>


                <tbody>

                    @if ($laporan['nihil'])
                        <tr>
                            <td colspan="14" class="fw-bold">
                                NIHIL
                            </td>
                        </tr>
                    @else
                        @foreach ($laporan['lhp'] as $item)
                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>
                                    {{ $item['obrik'] }}
                                </td>


                                <td>
                                    1
                                </td>


                                <td>
                                    {{ $item['temuan'] }}
                                </td>


                                <td>
                                    {{ $item['rekomendasi'] }}
                                </td>


                                <td>
                                    {{ $item['selesai'] }}
                                </td>


                                <td>
                                    {{ $item['dalam_proses'] }}
                                </td>


                                <td>
                                    {{ $item['belum'] }}
                                </td>


                                <td>
                                    Rp {{ number_format($item['kerugian']) }}
                                </td>


                                <td>
                                    Rp {{ number_format($item['disetor']) }}
                                </td>


                                <td>
                                    Rp {{ number_format($item['sisa']) }}
                                </td>


                                {{-- Pajak --}}
                                <td>
                                    Rp {{ number_format($item['pajak_nilai'] ?? 0) }}
                                </td>


                                <td>
                                    Rp {{ number_format($item['pajak_disetor'] ?? 0) }}
                                </td>


                                <td>
                                    Rp {{ number_format($item['pajak_sisa'] ?? 0) }}
                                </td>

                            </tr>
                        @endforeach
                    @endif


                    <tr class="fw-bold">

                        <td colspan="3">
                            JUMLAH
                        </td>

                        <td colspan="11"></td>

                    </tr>


                </tbody>

            </table>


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

            let tanggalAwal = document.querySelector('[name="tanggal_awal"]').value;

            let tanggalAkhir = document.querySelector('[name="tanggal_akhir"]').value;


            if (!irban) {
                alert('Silahkan pilih Wilayah Kerja (Irban) terlebih dahulu');
                return;
            }


            if (!tanggalAwal) {
                alert('Silahkan pilih Tanggal Awal terlebih dahulu');
                return;
            }


            if (!tanggalAkhir) {
                alert('Silahkan pilih Tanggal Akhir terlebih dahulu');
                return;
            }



            let url = "{{ route('laporan.irban.cetak') }}";


            url += "?irban_id=" + irban;

            url += "&tanggal_awal=" + tanggalAwal;

            url += "&tanggal_akhir=" + tanggalAkhir;



            window.open(url, '_blank');


        }
    </script>


@endsection
