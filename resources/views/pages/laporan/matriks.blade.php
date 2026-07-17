@extends('layouts.backend')

@section('content')
    <form method="GET" action="{{ route('matriks.index') }}" class="row g-3 mb-4">


        <div class="col-md-3">

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

            <label class="form-label">
                Tanggal Awal
            </label>

            <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">

        </div>



        <div class="col-md-2">

            <label class="form-label">
                Tanggal Akhir
            </label>

            <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">

        </div>



        <div class="col-md-2 d-flex align-items-end">

            <button class="btn btn-primary w-100">

                <i class="bi bi-search"></i>
                Tampilkan

            </button>

        </div>



        <div class="col-md-2 d-flex align-items-end">

            <a href="{{ route('matriks.index') }}" class="btn btn-secondary w-100">

                Reset

            </a>

        </div>


    </form>
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
                            <th>
                                {{ request('jenis') == 'eksternal' ? 'Pejabat Eksternal' : 'Auditee' }}
                            </th>
                            <th>Jumlah Temuan</th>
                            <th>Jumlah Rekomendasi</th>
                            <th>Jenis Tindak Lanjut</th>
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

                                    @if (request('jenis') == 'eksternal')
                                        {{ $item['nama_pejabat_eksternal'] ?? '-' }}
                                    @else
                                        {{ $item['auditee'] ?? '-' }}
                                    @endif

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

                                
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    @endsection
