@extends('layouts.backend')

@section('content')
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                Matriks Tindak Lanjut
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-sm align-middle " id="dataTable">

                    <thead class="table-light text-center">

                        <tr>
                            <th width="50">No</th>
                            <th>No. LHP</th>
                            <th>Tanggal</th>
                            <th>Auditee</th>
                            <th>Jumlah Temuan</th>
                            <th>Jumlah Rekomendasi</th>
                            <th>Jenis / Proses Tindak Lanjut</th>
                            <th>Status Tindak Lanjut</th>
                            <th>Pengembalian</th>
                            <th>Setor Pajak</th>
                            <th>Dokumen</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($matriks as $item)
                            <tr>

                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $item['nomor_lhp'] }}
                                </td>

                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item['tanggal'])->format('d-m-Y') }}
                                </td>

                                <td>
                                    {{ $item['auditee'] }}
                                </td>

                                <td class="text-center">
                                    {{ $item['temuan'] }}
                                </td>

                                <td class="text-center">
                                    {{ $item['rekomendasi'] }}
                                </td>

                                <td class="text-center">
                                    {{ $item['jenis_tindak_lanjut'] }}
                                </td>

                                <td class="text-center">

                                    @switch($item['status'])
                                        @case('Selesai')
                                            <span class="badge bg-success">
                                                Selesai
                                            </span>
                                        @break

                                        @case('Dalam Proses')
                                            <span class="badge bg-warning text-dark">
                                                Dalam Proses
                                            </span>
                                        @break

                                        @case('Belum Ditindaklanjuti')
                                            <span class="badge bg-danger">
                                                Belum Ditindaklanjuti
                                            </span>
                                        @break

                                        @default
                                            <span class="badge bg-secondary">
                                                -
                                            </span>
                                    @endswitch

                                </td>

                                <td class="text-end">
                                    Rp {{ number_format($item['pengembalian'], 0, ',', '.') }}
                                </td>

                                <td class="text-end">
                                    Rp {{ number_format($item['pajak'], 0, ',', '.') }}
                                </td>

                                <td class="text-center">

                                    @if ($item['dokumen'])
                                        <span class="badge bg-primary">
                                            Ada
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Tidak Ada
                                        </span>
                                    @endif

                                </td>

                            </tr>

                            @empty

                                <tr>
                                    <td colspan="11" class="text-center">
                                        Tidak ada data.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    @endsection
