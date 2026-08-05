@extends('layouts.backend')

@section('content')

    <div class="row mb-4">


        <div class="col-md-2 mb-3">

            <div class="card dashboard-card border-0 shadow-sm h-100">

                <div class="card-body">


                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Total Laporan
                            </small>


                            <h3 class="fw-bold mb-0">
                                {{ $statistik['total'] }}
                            </h3>
                        </div>
                        <div class="dashboard-icon bg-primary">

                            <i class="bi bi-folder fs-4"></i>

                        </div>
                    </div>





                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card dashboard-card border-0 shadow-sm h-100">

                <div class="card-body">


                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Tidak Dapat Ditindaklanjuti
                            </small>


                            <h3 class="fw-bold mb-0">
                                {{ $statistik['tt'] }}
                            </h3>
                        </div>
                        <div class="dashboard-icon bg-info">

                            <i class="bi bi-x-circle fs-4"></i>

                        </div>
                    </div>





                </div>

            </div>



        </div>

        <div class="col-md-2 mb-3">

            <div class="card dashboard-card border-0 shadow-sm h-100">

                <div class="card-body">


                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Dalam Proses
                            </small>


                            <h3 class="fw-bold mb-0">
                                {{ $statistik['dalam_proses'] }}
                            </h3>
                        </div>
                        <div class="dashboard-icon bg-warning">

                            <i class="bi bi-hourglass-split fs-4"></i>

                        </div>
                    </div>





                </div>

            </div>

        </div>
        <div class="col-md-2 mb-3">

            <div class="card dashboard-card border-0 shadow-sm h-100">

                <div class="card-body">


                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Selesai
                            </small>


                            <h3 class="fw-bold mb-0">
                                {{ $statistik['selesai'] }}
                            </h3>
                        </div>
                        <div class="dashboard-icon bg-success">

                            <i class="bi bi-check2-all fs-4"></i>

                        </div>
                    </div>





                </div>

            </div>

        </div>

        <div class="col-md-2 mb-3">

            <div class="card dashboard-card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Belum Ditindaklanjuti
                            </small>

                            <h3 class="fw-bold mb-0">
                                {{ $statistik['belum_ditindaklanjuti'] }}
                            </h3>

                        </div>


                        <div class="dashboard-icon bg-danger">

                            <i class="bi bi-hourglass fs-4"></i>

                        </div>


                    </div>

                </div>

            </div>

        </div>




    </div>
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <form method="GET" action="{{ url()->current() }}">

                <div class="row g-3">

                    <div class="col-md-2">

                        <label class="form-label">Jenis Laporan</label>

                        <select name="jenis_laporan" class="form-select">

                            <option value="">Semua Jenis Laporan</option>

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

                    @if ($jenis == 'internal')
                        <div class="col-md-2">

                            <label class="form-label">Irban</label>

                            <select name="irban_id" class="form-select">

                                <option value="">Semua Irban</option>

                                @foreach ($irbans as $irban)
                                    <option value="{{ $irban->id }}"
                                        {{ request('irban_id') == $irban->id ? 'selected' : '' }}>

                                        {{ $irban->nama_irban }}

                                    </option>
                                @endforeach

                            </select>

                        </div>
                    @else
                        <div class="col-md-2">

                            <label class="form-label">Tim Eksternal</label>

                            <select name="instansi_pemeriksa" class="form-select">

                                <option value="">Semua Tim Eksternal</option>

                                <option value="BPK RI" {{ request('instansi_pemeriksa') == 'BPK RI' ? 'selected' : '' }}>
                                    BPK RI
                                </option>

                                <option value="BPKP" {{ request('instansi_pemeriksa') == 'BPKP' ? 'selected' : '' }}>
                                    BPKP
                                </option>

                                <option value="Itprov" {{ request('instansi_pemeriksa') == 'Itprov' ? 'selected' : '' }}>
                                    Inspektorat Provinsi
                                </option>

                            </select>

                        </div>
                    @endif

                    <div class="col-md-2">

                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">

                            <option value="">Semua Status</option>

                            <option value="belum_ditindaklanjuti"
                                {{ request('status') == 'belum_ditindaklanjuti' ? 'selected' : '' }}>
                                Belum Ditindaklanjuti
                            </option>

                            <option value="dalam_proses" {{ request('status') == 'dalam_proses' ? 'selected' : '' }}>
                                Dalam Proses
                            </option>

                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                            <option value="tt" {{ request('status') == 'tt' ? 'selected' : '' }}>
                                Tidak Dapat Ditindaklanjuti
                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <label class="form-label">Dari</label>

                        <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-2">

                        <label class="form-label">Sampai</label>

                        <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                            class="form-control">

                    </div>

                    <div class="col-md-2 d-flex align-items-end">

                        <button class="btn btn-primary me-2">

                            <i class="bi bi-search"></i>

                            Filter

                        </button>

                        <a href="{{ url()->current() }}" class="btn btn-secondary">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>
    </div>
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">

                    <i class="bi bi-briefcase-fill me-2"></i>

                    Data Laporan
                    {{ ucfirst($jenis) }}

                </h5>

                <small class="text-muted mb-0">
                    Kelola data laporan
                </small>

            </div>
            @auth
                @if (auth()->user()->canCreateLhp())
                    @if ($jenis == 'internal')
                        <a href="{{ route('lhp.internal.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Tambah Laporan
                        </a>
                    @elseif($jenis == 'eksternal')
                        <a href="{{ route('lhp.eksternal.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            Tambah Laporan
                        </a>
                    @endif
                @endif
            @endauth


        </div>

        <div class="card-body">

            <div class="table-responsive">


                <table class="table table-hover align-middle" id="dataTable">


                    <thead class="table-light">

                        <tr>

                            <th width="5%">No</th>

                            <th>Jenis</th>

                            <th>Nomor Laporan</th>

                            @if ($jenis == 'eksternal')
                                <th>Instansi Pemeriksa</th>
                            @endif

                            <th>Irban</th>
                            @if ($jenis == 'internal')
                                <th>Auditee</th>
                            @endif

                            <th>Objek Pemeriksaan</th>

                            <th>Temuan</th>

                            <th>Rekomendasi</th>

                            <th>Progress</th>

                            <th>Status</th>

                            <th style="width:10px">Aksi</th>


                        </tr>

                    </thead>



                    <tbody>


                        @forelse($lhps as $l)
                            @php

                                $totalTemuan = $l->temuans->count();

                                $totalRekomendasi = $l->temuans->sum(function ($temuan) {
                                    return $temuan->rekomendasis->count();
                                });

                                $totalTindakLanjut = $l->temuans->sum(function ($temuan) {
                                    return $temuan->rekomendasis->sum(function ($rek) {
                                        return $rek->tindakLanjut->count();
                                    });
                                });

                                $progress =
                                    $totalRekomendasi > 0 ? round(($totalTindakLanjut / $totalRekomendasi) * 100) : 0;

                            @endphp





                            <tr>


                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    @switch($l->jenis_laporan)
                                        @case('LHP')
                                            <span class="badge bg-primary">LHP</span>
                                        @break

                                        @case('LHA')
                                            <span class="badge bg-success">LHA</span>
                                        @break

                                        @case('LHE')
                                            <span class="badge bg-warning text-dark">LHE</span>
                                        @break

                                        @case('LHR')
                                            <span class="badge bg-danger">LHR</span>
                                        @break

                                        @default
                                            <span class="badge bg-secondary">
                                                {{ $l->jenis_laporan }}
                                            </span>
                                    @endswitch
                                </td>

                                <td>

                                    <strong>

                                        {{ $l->nomor_lhp }}

                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        {{ \Carbon\Carbon::parse($l->tanggal_lhp)->format('d-m-Y') }}

                                    </small>


                                </td>

                                @if ($jenis == 'eksternal')
                                    <td>

                                        @switch($l->instansi_pemeriksa)
                                            @case('Itprov')
                                                <span class="badge bg-success">
                                                    Inspektorat Provinsi
                                                </span>
                                            @break

                                            @case('BPK RI')
                                                <span class="badge bg-danger">
                                                    Badan Pemeriksa Keuangan Republik Indonesia
                                                </span>
                                            @break

                                            @case('BPKP')
                                                <span class="badge bg-dark">
                                                    Badan Pengawasan Keuangan dan Pembangunan
                                                </span>
                                            @break
                                        @endswitch

                                    </td>
                                @endif

                                <td>

                                    {{ $l->irban->nama_irban ?? '-' }}

                                </td>

                                @if ($jenis == 'internal')
                                    <td>

                                        {{ $l->auditee->nama_dinas ?? '-' }}

                                    </td>
                                @endif





                                <td>

                                    @if ($l->objekPemeriksaans->count())
                                        <ol class="mb-0 ps-3">

                                            @foreach ($l->objekPemeriksaans as $objek)
                                                <li>
                                                    {{ $objek->nama_objek }}
                                                </li>
                                            @endforeach

                                        </ol>
                                    @else
                                        -
                                    @endif

                                </td>





                                <td>

                                    @if ($totalTemuan == 0)
                                        @if ($l->status_proses == 'nihil')
                                            <span class="badge bg-info">
                                                Nihil
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                Belum Ada Temuan
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge bg-danger">

                                            {{ $totalTemuan }} Temuan

                                        </span>
                                    @endif


                                </td>





                                <td>

                                    <span class="badge bg-primary">

                                        <i class="bi bi-list-check"></i>

                                        {{ $totalRekomendasi }}

                                    </span>


                                </td>






                                <td width="15%">

                                    @if ($totalRekomendasi > 0)
                                        <small>

                                            {{ $l->totalSelesai }}
                                            /
                                            {{ $l->totalRekomendasi }}
                                            Selesai

                                        </small>

                                        <div class="progress mb-2" style="height:8px">
                                            <div class="progress-bar" style="width: {{ $l->progress }}%">
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            Tidak ada rekomendasi
                                        </span>
                                    @endif


                                </td>







                                <td>


                                    @if ($l->status_proses == 'tt')
                                        <span class="badge bg-info">
                                            Tidak Dapat Ditindaklanjuti
                                        </span>
                                    @elseif($l->status_proses == 'belum_ditindaklanjuti')
                                        <span class="badge bg-secondary">
                                            Belum Ditindaklanjuti
                                        </span>
                                    @elseif($l->status_proses == 'dalam_proses')
                                        <span class="badge bg-warning">
                                            Dalam Proses
                                        </span>
                                    @elseif($l->status_proses == 'selesai')
                                        <span class="badge bg-success">
                                            Selesai
                                        </span>
                                    @endif


                                </td>







                                <td class="wrap-text">


                                    <div class="d-flex gap-1">



                                        {{-- @if ($l->status_proses != 'selesai' && $l->totalSelesai == $l->totalRekomendasi && $l->totalRekomendasi > 0)
                                            <form action="{{ route('lhp.selesai', $l->id) }}" method="POST"
                                                onsubmit="return confirm('Selesaikan LHP ini?')">

                                                @csrf
                                                @method('PUT')


                                                <button class="btn btn-sm btn-success">

                                                    <i class="bi bi-check-circle"></i> Selesaikan Proses

                                                </button>


                                            </form>
                                        @endif --}}


                                        <a href="{{ route('lhp.show', $l->id) }}" class="btn btn-primary btn-sm">

                                            <i class="bi bi-eye"></i> Detail

                                        </a>

                                        @auth
                                            @if (auth()->user()->role == 'super_user')
                                                {{-- @if ($l->status_proses == 'belum_ditindaklanjuti')
                                                    <form action="{{ route('lhp.tetapkan-tt', $l->id) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Tetapkan LHP ini sebagai Tidak Dapat Ditindaklanjuti?')">

                                                        @csrf

                                                        <button class="btn btn-sm btn-secondary">

                                                            <i class="bi bi-x-circle"></i>

                                                            Tidakdapat Ditindak Lanjuti

                                                        </button>

                                                    </form>
                                                @endif --}}


                                                <a href="{{ route('lhp.edit', $l->id) }}" class="btn btn-warning btn-sm">

                                                    <i class="bi bi-pencil"></i>

                                                    Edit

                                                </a>




                                                <form action="{{ route('lhp.destroy', $l->id) }}" method="POST">


                                                    @csrf
                                                    @method('DELETE')


                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Hapus LHP?')">


                                                        <i class="bi bi-trash"></i>
                                                        Hapus

                                                    </button>


                                                </form>
                                            @endif
                                        @endauth



                                    </div>


                                </td>



                            </tr>



                            @empty
                            @endforelse


                        </tbody>


                    </table>


                </div>

            </div>

            @if ($errors->any())
                <div class="alert alert-danger">

                    <strong>Terjadi kesalahan:</strong>

                    <ul class="mb-0 mt-2">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>
            @endif

        </div>

        <style>
            #dataTable {
                font-size: 12px;
            }

            .table-responsive {
                overflow-x: auto;
            }

            #dataTable th {
                font-size: 10px;
            }

            #dataTable td {
                vertical-align: middle;
            }

            #dataTable .btn {
                padding: .2rem .4rem;
                font-size: 10px;
            }

            #dataTable .badge {
                font-size: 10px;
            }
        </style>

    @endsection
