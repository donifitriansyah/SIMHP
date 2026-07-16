@extends('layouts.backend')

@section('content')

    <div class="container-fluid py-4">

        {{-- Header --}} <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="fw-bold mb-1"> Detail Laporan Hasil Pemeriksaan </h4>

                <p class="text-muted mb-0"> Informasi lengkap laporan hasil pemeriksaan </p>

            </div>

            <div>

                <a href="{{ route('lhp.index') }}" class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i> Kembali

                </a>
                <a href="{{ route('lhp.cetak', $lhp->id) }}" target="_blank" class="btn btn-danger">
                    <i class="bi bi-printer"></i>
                    Cetak PDF
                </a>
                @auth
                    @if (auth()->user()->role == 'super_user')
                        <a href="{{ route('lhp.edit', $lhp->id) }}" class="btn btn-warning">

                            <i class="bi bi-pencil"></i> Edit

                        </a>
                    @endif
                @endauth


            </div>

        </div>

        {{-- Informasi LHP --}} <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-primary text-white">

                <h5 class="mb-0"> Informasi Pemeriksaan </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="text-muted"> Nomor LHP </label>

                        <h6> {{ $lhp->nomor_lhp }} </h6>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-muted"> Tanggal LHP </label>

                        <h6> {{ \Carbon\Carbon::parse($lhp->tanggal_lhp)->format('d-m-Y') }} </h6>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-muted"> Nomor Surat Tugas </label>

                        <h6> {{ $lhp->nomor_spt }} </h6>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-muted"> Tanggal SPT </label>

                        <h6> {{ \Carbon\Carbon::parse($lhp->tanggal_spt)->format('d-m-Y') }} </h6>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-muted"> Tahun PKPT </label>

                        <h6> {{ $lhp->tahun_pkpt }} </h6>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-muted"> Dana Diawasi </label>

                        <h6> Rp {{ number_format($lhp->jumlah_dana_diawasi, 0, ',', '.') }} </h6>

                    </div>

                </div>

            </div>

        </div>

        {{-- Entitas Pemeriksaan --}} <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-info text-white">

                <h5 class="mb-0"> Entitas Pemeriksaan </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">

                        <label class="text-muted"> Irban </label>

                        <h6> {{ $lhp->irban->nama_irban ?? '-' }} </h6>

                    </div>

                    <div class="col-md-4">

                        <label class="text-muted"> Auditee </label>

                        <h6> {{ $lhp->auditee->nama_dinas ?? '-' }} </h6>

                    </div>

                    <div class="col-md-4">

                        <label class="text-muted"> Entitas yang Diperiksa </label>

                        <h6>

                            {{ $lhp->pejabatAuditee->nama ?? '-' }}

                            @if ($lhp->pejabatAuditee)
                                <br> <small class="text-muted"> {{ $lhp->pejabatAuditee->jenis_jabatan }} </small>
                            @endif

                        </h6>

                    </div>

                    <div class="col-md-4">

                        <label class="text-muted"> Pihak Ketiga </label>

                        <h6> {{ $lhp->pihakKetiga->nama_perusahaan ?? '-' }} </h6>

                    </div>

                    <div class="col-md-4 mt-3">

                        <label class="text-muted"> Objek Pemeriksaan </label>

                        <h6> {{ $lhp->objek_pemeriksaan }} </h6>

                    </div>

                    <div class="col-md-4 mt-3">

                        <label class="text-muted"> Jenis Pemeriksaan </label>

                        <h6>

                            <span class="badge bg-primary">

                                {{ strtoupper($lhp->jenis_pemeriksaan) }}

                            </span>

                        </h6>

                    </div>

                    <div class="col-md-4 mt-3">

                        <label class="text-muted"> Status LHP </label>

                        <h6>

                            @if ($lhp->status_lhp == 'lengkap')
                                <span class="badge bg-success"> Lengkap </span>
                            @else
                                <span class="badge bg-warning"> Tidak Lengkap </span>
                            @endif

                        </h6>

                    </div>

                </div>

            </div>

        </div>

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-secondary text-white">

                <h5 class="mb-0"> Dokumen LHP </h5>

            </div>

            <div class="card-body">

                @forelse($lhp->dokumen as $dok)
                    <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">

                        <div>

                            <i class="bi bi-file-earmark-text me-2"></i>

                            <strong>{{ $dok->nama_file }}</strong>

                            <br>

                            <small class="text-muted"> {{ strtoupper($dok->tipe_file) }} </small>

                        </div>

                        <div>

                            <a href="{{ asset('storage/' . $dok->path_file) }}" target="_blank"
                                class="btn btn-sm btn-primary">

                                <i class="bi bi-eye"></i> Lihat

                            </a>

                            <a href="{{ asset('storage/' . $dok->path_file) }}" download class="btn btn-sm btn-success">

                                <i class="bi bi-download"></i> Download

                            </a>

                        </div>

                    </div>

                @empty

                    <div class="text-center text-muted py-3">

                        <i class="bi bi-folder2-open fs-2"></i>

                        <p class="mb-0 mt-2"> Belum ada dokumen LHP. </p>

                    </div>
                @endforelse

            </div>

        </div>

        @if ($lhp->status_proses == 'nihil')
            <div class="alert alert-info">

                <i class="bi bi-info-circle"></i>

                <strong>LHP Nihil</strong>

                <br>

                Pemeriksaan tidak memiliki temuan sehingga tidak diperlukan tindak lanjut.

            </div>
        @endif

        {{-- Temuan Pemeriksaan --}} <div class="card shadow-sm border-0 mb-4">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0 fw-bold"> <i class="bi bi-search"></i> Temuan Pemeriksaan </h5>

                @if ($lhp->status_proses != 'nihil')
                    <a href="{{ route('temuan.create', $lhp->id) }}" class="btn btn-primary">

                        <i class="bi bi-plus"></i> Tambah Temuan

                    </a>
                @endif

            </div>

            <div class="card-body">

                <div class="accordion" id="accordionTemuan">

                    @forelse($lhp->temuans as $temuan)
                        <div class="accordion-item mb-3 border rounded">

                            <h2 class="accordion-header">

                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#temuan{{ $temuan->id }}">

                                    <div>

                                        <strong> Temuan Nomor {{ $temuan->nomor_temuan }} </strong>

                                        <br>

                                        <small class="text-muted">

                                            {{ Str::limit($temuan->uraian_temuan, 100) }}

                                        </small>

                                    </div>

                                </button>

                            </h2>

                            <div id="temuan{{ $temuan->id }}" class="accordion-collapse collapse"
                                data-bs-parent="#accordionTemuan">

                                <div class="accordion-body">

                                    {{-- DETAIL TEMUAN --}}

                                    <div class="card border-danger mb-4">

                                        <div class="card-header bg-danger text-white">

                                            <strong> Detail Temuan </strong>

                                        </div>

                                        <div class="card-body">

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <label class="text-muted"> Uraian Temuan </label>

                                                    <p> {{ $temuan->uraian_temuan }} </p>

                                                </div>

                                                <div class="col-md-6">

                                                    <label class="text-muted"> Uraian Administrasi </label>

                                                    <p> {{ $temuan->administrasi ?? '-' }} </p>

                                                </div>

                                                <div class="col-md-12"> <label class="text-muted"> Nilai Kerugian </label>
                                                    <p class="fw-bold text-danger"> Rp
                                                        {{ $temuan->nilai_kerugian ? number_format($temuan->nilai_kerugian, 2, ',', '.') : '-' }}
                                                    </p>
                                                </div>

                                                <div class="col-md-12">

                                                    <label class="text-muted"> Nama Pelaku </label>

                                                    <p> {{ $temuan->nama_pelaku ?? '-' }} </p>

                                                </div>

                                            </div>
                                            @auth
                                                @if (auth()->user()->role == 'super_user')
                                                    <a href="{{ route('temuan.edit', $temuan->id) }}"
                                                        class="btn btn-warning btn-sm">

                                                        <i class="bi bi-pencil"></i> Edit Temuan

                                                    </a>

                                                    <form action="{{ route('temuan.destroy', $temuan->id) }}" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Hapus temuan ini?')">

                                                        @csrf @method('DELETE')

                                                        <button type="submit" class="btn btn-sm btn-danger">

                                                            <i class="bi bi-trash"></i> Hapus

                                                        </button>

                                                    </form>
                                                @endif
                                            @endauth


                                        </div>

                                    </div>

                                    {{-- REKOMENDASI --}}

                                    <div class="d-flex justify-content-between mb-3">

                                        <h6 class="fw-bold text-primary">

                                            <i class="bi bi-check-circle"></i>

                                            Rekomendasi

                                        </h6>

                                        @auth
                                            @if (auth()->user()->role == 'super_user')
                                                <a href="{{ route('rekomendasi.create', $temuan->id) }}"
                                                    class="btn btn-primary btn-sm">

                                                    <i class="bi bi-plus"></i> Tambah

                                                </a>
                                            @endif
                                        @endauth



                                    </div>

                                    @forelse($temuan->rekomendasis as $rekomendasi)
                                        <div class="card border-primary mb-3">

                                            <div class="card-header bg-primary text-white">

                                                <strong>

                                                    Rekomendasi

                                                </strong>

                                            </div>

                                            <div class="card-body">

                                                <div class="col-md-6">

                                                    <label class="text-muted">

                                                        Uraian Penyebab

                                                    </label>

                                                    <p>

                                                        {{ $rekomendasi->uraian_rekomendasi }}

                                                    </p>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <label class="text-muted">

                                                            Uraian Administrasi

                                                        </label>

                                                        <p>

                                                            {{ $rekomendasi->administrasi ?? '-' }}

                                                        </p>

                                                    </div>

                                                    <div class="col-md-12">

                                                        <label class="text-muted">

                                                            Nilai Finansial

                                                        </label>

                                                        <p class="fw-bold">

                                                            Rp
                                                            {{ $rekomendasi->nilai_finansial ? number_format($rekomendasi->nilai_finansial, 2, ',', '.') : '-' }}

                                                        </p>

                                                    </div>
                                                    <div class="col-md-12">

                                                        <label class="text-muted">

                                                            Kewajiban Setor Pajak

                                                        </label>

                                                        <p class="fw-bold">

                                                            Rp
                                                            {{ number_format($rekomendasi->nilai_pajak ?? 0, 0, ',', '.') }}

                                                        </p>

                                                    </div>

                                                </div>
                                                @auth
                                                    @if (auth()->user()->role == 'super_user')
                                                        <a href="{{ route('rekomendasi.edit', $rekomendasi->id) }}"
                                                            class="btn btn-warning btn-sm">

                                                            <i class="bi bi-pencil"></i>

                                                            Edit

                                                        </a>
                                                        <form action="{{ route('rekomendasi.destroy', $rekomendasi->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Hapus rekomendasi ini?')">

                                                            @csrf @method('DELETE')

                                                            <button type="submit" class="btn btn-sm btn-danger">

                                                                <i class="bi bi-trash"></i> Hapus

                                                            </button>

                                                        </form>
                                                    @endif
                                                @endauth


                                                {{-- TINDAK LANJUT --}}

                                                <hr>

                                                <div class="d-flex justify-content-between align-items-center">

                                                    <h6 class="fw-bold text-success">

                                                        <i class="bi bi-arrow-repeat"></i>

                                                        Tindak Lanjut

                                                    </h6>
                                                    @auth
                                                        @if (auth()->user()->role == 'super_user')
                                                            <a href="{{ route('tindak-lanjut.create', $rekomendasi->id) }}"
                                                                class="btn btn-success btn-sm">

                                                                <i class="bi bi-plus"></i>

                                                                Tambah

                                                            </a>
                                                        @endif
                                                    @endauth


                                                </div>

                                                @forelse($rekomendasi->tindakLanjut as $tl)
                                                    <div class="card border-success mt-3">

                                                        <div class="card-body">

                                                            <div class="mb-2">

                                                                <strong> Status: </strong>
                                                                <br>
                                                                <span class="badge bg-success">

                                                                    {{ $tl->status->nama_status ?? '-' }}

                                                                </span>

                                                            </div>
                                                            <div class="mb-2">

                                                                <strong> Jenis Tindak Lanjut: </strong>

                                                                <p>
                                                                    {{ $tl->jenis_tindak_lanjut ?? '-' }}
                                                                </p>


                                                            </div>

                                                            <div class="mb-2">

                                                                <strong> Narasi: </strong>

                                                                <p> {{ $tl->narasi }} </p>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-md-6">

                                                                    <strong> Pengembalian: </strong>

                                                                    <p>

                                                                        Rp
                                                                        {{ number_format($tl->nilai_pengembalian ?? 0, 0, ',', '.') }}

                                                                    </p>

                                                                </div>

                                                                <div class="col-md-6">

                                                                    <strong> Setor Pajak: </strong>

                                                                    <p>

                                                                        Rp
                                                                        {{ number_format($tl->nilai_setor_pajak ?? 0, 0, ',', '.') }}

                                                                    </p>

                                                                </div>

                                                            </div>

                                                            <strong> Dokumen: </strong>

                                                            <ul>

                                                                @forelse($tl->dokumen as $dok)
                                                                    <li>

                                                                        <a href="{{ asset('storage/' . $dok->path_file) }}"
                                                                            target="_blank">

                                                                            <i class="bi bi-file-earmark"></i>

                                                                            {{ $dok->nama_file }}

                                                                        </a>

                                                                    </li>

                                                                @empty

                                                                    <li class="text-muted">

                                                                        Tidak ada dokumen

                                                                    </li>
                                                                @endforelse

                                                            </ul>
                                                            @auth
                                                                @if (auth()->user()->role == 'super_user')
                                                                    <a href="{{ route('tindak-lanjut.edit', $tl->id) }}"
                                                                        class="btn btn-warning btn-sm">

                                                                        <i class="bi bi-pencil"></i>

                                                                        Edit

                                                                    </a>

                                                                    <form
                                                                        action="{{ route('tindak-lanjut.destroy', $tl->id) }}"
                                                                        method="POST" class="d-inline">

                                                                        @csrf @method('DELETE')

                                                                        <button class="btn btn-danger btn-sm"
                                                                            onclick="return confirm('Hapus tindak lanjut?')">

                                                                            <i class="bi bi-trash"></i>

                                                                            Hapus

                                                                        </button>

                                                                    </form>
                                                                @endif
                                                            @endauth


                                                        </div>

                                                    </div>

                                                @empty

                                                    <div class="alert alert-light">

                                                        Belum ada tindak lanjut

                                                    </div>
                                                @endforelse

                                            </div>

                                        </div>

                                    @empty

                                        <div class="alert alert-light">

                                            Belum ada rekomendasi

                                        </div>
                                    @endforelse

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="text-center text-muted">

                            Belum ada temuan

                        </div>
                    @endforelse

                </div>

            </div>

        </div>

    @endsection
