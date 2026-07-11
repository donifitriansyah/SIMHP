@extends('layouts.backend')

@section('content')

    <div class="row mb-4">


        <div class="col-md-3 mb-3">

            <div class="card dashboard-card border-0 shadow-sm h-100">

                <div class="card-body">


                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Total LHP
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




        <div class="col-md-3 mb-3">

            <div class="card dashboard-card border-0 shadow-sm h-100">

                <div class="card-body">


                    <div class="d-flex justify-content-between">

                        <div>
                            <small class="text-muted">
                                Nihil
                            </small>


                            <h3 class="fw-bold mb-0">
                                {{ $statistik['nihil'] }}
                            </h3>
                        </div>
                        <div class="dashboard-icon bg-info">

                            <i class="bi bi-check-circle fs-4"></i>

                        </div>
                    </div>





                </div>

            </div>



        </div>





        <div class="col-md-3 mb-3">

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
        <div class="col-md-3 mb-3">

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




    </div>
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">
                    <i class="bi bi-briefcase-fill me-2"></i>
                    Data Laporan Hasil Pemeriksaan (LHP)
                </h5>

                <small class="text-muted mb-0">
                    Kelola data laporan hasil pemeriksaan
                </small>

            </div>

            <a href="{{ route('lhp.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>
                Tambah LHP

            </a>

        </div>

        <div class="card-body">



            <div class="table-responsive">


                <table class="table table-hover align-middle" id="dataTable">


                    <thead class="table-light">

                        <tr>

                            <th width="5%">No</th>

                            <th>Nomor LHP</th>

                            <th>Auditee</th>

                            <th>Objek Pemeriksaan</th>

                            <th>Temuan</th>

                            <th>Rekomendasi</th>

                            <th>Progress</th>

                            <th>Status</th>

                            <th>Aksi</th>


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

                                    <strong>

                                        {{ $l->nomor_lhp }}

                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        {{ \Carbon\Carbon::parse($l->tanggal_lhp)->format('d-m-Y') }}

                                    </small>


                                </td>




                                <td>

                                    {{ $l->auditee->nama_dinas ?? '-' }}

                                </td>





                                <td>

                                    {{ $l->objekPemeriksaan->nama_objek ?? '-' }}

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
                                        <div class="progress mb-2" style="height:8px">

                                            <div class="progress-bar" style="width: {{ $progress }}%">
                                            </div>

                                        </div>


                                        <small>

                                            {{ $totalTindakLanjut }}
                                            /
                                            {{ $totalRekomendasi }}

                                            Selesai

                                        </small>
                                    @else
                                        <span class="text-muted">
                                            Tidak ada rekomendasi
                                        </span>
                                    @endif


                                </td>







                                <td>


                                    @if ($l->status_proses == 'nihil')
                                        <span class="badge bg-info">
                                            Nihil
                                        </span>
                                    @elseif($l->status_proses == 'belum_diproses')
                                        <span class="badge bg-secondary">
                                            Belum Diproses
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







                                <td>


                                    <div class="d-flex gap-1">

                                        @if ($l->status_proses == 'belum_diproses')
                                            <form action="{{ route('lhp.tetapkan-nihil', $l->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Tetapkan LHP ini sebagai Nihil?')">


                                                @csrf


                                                <button class="btn btn-sm btn-info">

                                                    <i class="bi bi-check-circle"></i>

                                                    Nihil

                                                </button>


                                            </form>
                                        @endif

                                        @if ($l->status_proses != 'selesai' && $l->totalSelesai == $l->totalRekomendasi && $l->totalRekomendasi > 0)
                                            <form action="{{ route('lhp.selesai', $l->id) }}" method="POST"
                                                onsubmit="return confirm('Selesaikan LHP ini?')">

                                                @csrf
                                                @method('PUT')


                                                <button class="btn btn-sm btn-success">

                                                    <i class="bi bi-check-circle"></i> Selesaikan Proses

                                                </button>


                                            </form>
                                        @endif


                                        <a href="{{ route('lhp.show', $l->id) }}" class="btn btn-primary btn-sm">

                                            <i class="bi bi-eye"></i> Detail

                                        </a>



                                        <a href="{{ route('lhp.edit', $l->id) }}" class="btn btn-warning btn-sm">

                                            <i class="bi bi-pencil"></i>

                                        </a>




                                        <form action="{{ route('lhp.destroy', $l->id) }}" method="POST">


                                            @csrf
                                            @method('DELETE')


                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus LHP?')">


                                                <i class="bi bi-trash"></i>


                                            </button>


                                        </form>


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
@endsection
