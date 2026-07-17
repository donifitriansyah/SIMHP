@extends('layouts.backend')

@section('content')
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                Temuan berdasarkan PNS
            </h5>
        </div>

        <div class="card-body">


            <form method="GET" action="{{ route('laporan.pns.temuan') }}" class="row g-3 mb-4">

                <div class="col-md-3">

                    <label class="form-label">
                        Jenis Pemeriksaan
                    </label>

                    <select name="jenis" class="form-select" required>

                        <option value="internal" {{ request('jenis', 'internal') == 'internal' ? 'selected' : '' }}>
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

                    <a href="{{ route('laporan.pns.temuan') }}" class="btn btn-secondary w-100">

                        Reset

                    </a>

                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('laporan.pns.temuan.cetak', request()->query()) }}" target="_blank"
                        class="btn btn-success w-100">

                        <i class="bi bi-printer"></i>
                        Cetak

                    </a>

                </div>


            </form>

            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Nama PNS</th>

                            @if ($jenis == 'internal')
                                <th>Jabatan</th>
                                <th>Instansi</th>
                            @endif
                             @if ($jenis == 'eksternal')
                                <th>Instansi Pemeriksa</th>
                            @endif

                            <th>Jumlah Temuan</th>

                        </tr>

                    </thead>


                    <tbody>


                        @if ($jenis == 'internal')
                            {{-- DATA PEJABAT AUDITEE --}}

                            @foreach ($pegawai as $item)
                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $item->nama }}
                                    </td>

                                    <td>
                                        {{ $item->jenis_jabatan }}
                                    </td>

                                    <td>
                                        {{ $item->auditee->nama_dinas ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->lhps->sum(function ($lhp) {
                                            return $lhp->temuans->count();
                                        }) }}
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            {{-- DATA EKSTERNAL DARI LHP --}}

                            @foreach ($lhps as $lhp)
                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $lhp->nama_pejabat_eksternal }}
                                    </td>

                                    <td>

                                        @switch($lhp->instansi_pemeriksa)
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
                                        {{ $lhp->temuans->count() }}
                                    </td>

                                </tr>
                            @endforeach
                        @endif


                    </tbody>


                </table>

            </div>

        </div>
    @endsection
