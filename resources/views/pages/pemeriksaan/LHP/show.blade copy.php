@extends('layouts.backend')

@section('content')

    <div class="container-fluid py-4">


        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="fw-bold mb-1">
                    Detail Laporan Hasil Pemeriksaan
                </h4>

                <p class="text-muted mb-0">
                    Informasi lengkap laporan hasil pemeriksaan
                </p>

            </div>


            <div>

                <a href="{{ route('lhp.index') }}" class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>
                    Kembali

                </a>


                <a href="{{ route('lhp.edit', $lhp->id) }}" class="btn btn-warning">

                    <i class="bi bi-pencil"></i>
                    Edit

                </a>

            </div>

        </div>




        {{-- Informasi LHP --}}
        <div class="card shadow-sm border-0 mb-4">


            <div class="card-header bg-primary text-white">

                <h5 class="mb-0">
                    Informasi Pemeriksaan
                </h5>

            </div>



            <div class="card-body">


                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Nomor LHP
                        </label>

                        <h6>
                            {{ $lhp->nomor_lhp }}
                        </h6>

                    </div>



                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Tanggal LHP
                        </label>

                        <h6>
                            {{ \Carbon\Carbon::parse($lhp->tanggal_lhp)->format('d-m-Y') }}
                        </h6>

                    </div>



                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Nomor Surat Tugas
                        </label>

                        <h6>
                            {{ $lhp->nomor_spt }}
                        </h6>

                    </div>



                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Tanggal SPT
                        </label>

                        <h6>
                            {{ \Carbon\Carbon::parse($lhp->tanggal_spt)->format('d-m-Y') }}
                        </h6>

                    </div>



                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Tahun PKPT
                        </label>

                        <h6>
                            {{ $lhp->tahun_pkpt }}
                        </h6>

                    </div>



                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Dana Diawasi
                        </label>

                        <h6>
                            Rp {{ number_format($lhp->jumlah_dana_diawasi, 0, ',', '.') }}
                        </h6>

                    </div>


                </div>


            </div>


        </div>





        {{-- Entitas Pemeriksaan --}}
        <div class="card shadow-sm border-0 mb-4">


            <div class="card-header bg-info text-white">

                <h5 class="mb-0">
                    Entitas Pemeriksaan
                </h5>

            </div>



            <div class="card-body">


                <div class="row">


                    <div class="col-md-4">

                        <label class="text-muted">
                            Irban
                        </label>

                        <h6>
                            {{ $lhp->irban->nama_irban ?? '-' }}
                        </h6>

                    </div>



                    <div class="col-md-4">

                        <label class="text-muted">
                            Auditee
                        </label>

                        <h6>
                            {{ $lhp->auditee->nama_dinas ?? '-' }}
                        </h6>

                    </div>



                    <div class="col-md-4">

                        <label class="text-muted">
                            Pihak Ketiga
                        </label>

                        <h6>
                            {{ $lhp->pihakKetiga->nama_perusahaan ?? '-' }}
                        </h6>

                    </div>



                    <div class="col-md-4 mt-3">

                        <label class="text-muted">
                            Objek Pemeriksaan
                        </label>

                        <h6>
                            {{ $lhp->objekPemeriksaan->nama_objek ?? '-' }}
                        </h6>

                    </div>



                    <div class="col-md-4 mt-3">

                        <label class="text-muted">
                            Jenis Pemeriksaan
                        </label>

                        <h6>

                            <span class="badge bg-primary">

                                {{ strtoupper($lhp->jenis_pemeriksaan) }}

                            </span>

                        </h6>

                    </div>



                    <div class="col-md-4 mt-3">

                        <label class="text-muted">
                            Status LHP
                        </label>

                        <h6>

                            @if ($lhp->status_lhp == 'Lengkap')
                                <span class="badge bg-success">
                                    Lengkap
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    Tidak Lengkap
                                </span>
                            @endif

                        </h6>

                    </div>


                </div>


            </div>


        </div>





        {{-- Temuan --}}
        <div class="card shadow-sm border-0 mb-4">


            <div class="card-header d-flex justify-content-between">


                <h5 class="mb-0">
                    Temuan Pemeriksaan
                </h5>


                <a href="{{ route('temuan.create', $lhp->id) }}" class="btn btn-sm btn-primary">

                    <i class="bi bi-plus"></i>
                    Tambah Temuan

                </a>




            </div>




            {{-- Temuan Pemeriksaan --}}

            <div class="card-body">


                @forelse($lhp->temuans as $temuan)
                    <div class="card border mb-4">


                        <div class="card-header bg-light">


                            <h6 class="fw-bold mb-0">

                                Temuan Nomor {{ $temuan->nomor_temuan }}

                            </h6>




                        </div>




                        <div class="card-body">


                            <div class="row">


                                <div class="col-md-12 mb-3">


                                    <label class="text-muted">
                                        Uraian Temuan
                                    </label>


                                    <p>
                                        {{ $temuan->uraian_temuan }}
                                    </p>


                                </div>



                                <div class="col-md-6">


                                    <label class="text-muted">
                                        Administrasi
                                    </label>


                                    <p>
                                        {{ $temuan->administrasi ?? '-' }}
                                    </p>


                                </div>



                                <div class="col-md-6">


                                    <label class="text-muted">
                                        Nilai Kerugian
                                    </label>


                                    <p class="fw-bold">

                                        Rp
                                        {{ number_format($temuan->nilai_kerugian, 0, ',', '.') }}

                                    </p>


                                </div>



                                <div class="col-md-6">


                                    <label class="text-muted">
                                        Nama Pelaku
                                    </label>


                                    <p>
                                        {{ $temuan->nama_pelaku ?? '-' }}
                                    </p>


                                </div>

                                <div>
                                    <a href="{{ route('temuan.edit', $temuan->id) }}" class="btn btn-sm btn-warning">

                                        <i class="bi bi-pencil"></i> Edit

                                    </a>

                                    <form action="{{ route('temuan.destroy', $temuan->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus temuan ini?')">


                                        @csrf
                                        @method('DELETE')


                                        <button type="submit" class="btn btn-sm btn-danger">

                                            <i class="bi bi-trash"></i>
                                            Hapus

                                        </button>


                                    </form>
                                </div>



                            </div>




                            {{-- Rekomendasi --}}

                            <hr>


                            <div class="d-flex justify-content-between align-items-center mb-3">


                                <h6 class="fw-bold text-primary mb-0">

                                    Rekomendasi

                                </h6>



                                <a href="{{ route('rekomendasi.create', $temuan->id) }}" class="btn btn-sm btn-primary">

                                    <i class="bi bi-plus"></i>
                                    Tambah Rekomendasi

                                </a>


                            </div>




                            @forelse($temuan->rekomendasis as $rekomendasi)
                                <div class="alert alert-light border">


                                    <div class="row">


                                        <div class="col-md-12 mb-2">

                                            <label class="text-muted">
                                                Uraian Rekomendasi
                                            </label>


                                            <p class="mb-0">
                                                {{ $rekomendasi->uraian_rekomendasi }}
                                            </p>


                                        </div>



                                        <div class="col-md-6">

                                            <label class="text-muted">
                                                Administrasi
                                            </label>


                                            <p>
                                                {{ $rekomendasi->administrasi ?? '-' }}
                                            </p>


                                        </div>



                                        <div class="col-md-6">

                                            <label class="text-muted">
                                                Nilai Finansial
                                            </label>


                                            <p class="fw-bold">

                                                Rp {{ number_format($rekomendasi->nilai_finansial ?? 0, 0, ',', '.') }}

                                            </p>


                                        </div>


                                    </div>



                                    <hr>


                                    {{-- Tombol Rekomendasi --}}

                                    <div class="d-flex flex-wrap gap-2 mb-3">


                                        <a href="{{ route('rekomendasi.edit', $rekomendasi->id) }}"
                                            class="btn btn-warning btn-sm">

                                            <i class="bi bi-pencil"></i>
                                            Edit Rekomendasi

                                        </a>



                                        <form action="{{ route('rekomendasi.destroy', $rekomendasi->id) }}" method="POST"
                                            class="m-0" onsubmit="return confirm('Hapus rekomendasi ini?')">


                                            @csrf
                                            @method('DELETE')


                                            <button type="submit" class="btn btn-danger btn-sm">

                                                <i class="bi bi-trash"></i>
                                                Hapus Rekomendasi

                                            </button>


                                        </form>


                                    </div>





                                    {{-- Tindak Lanjut --}}

                                    <div class="card border-success">


                                        <div
                                            class="card-header bg-success text-white d-flex justify-content-between align-items-center">


                                            <span class="fw-bold">
                                                Tindak Lanjut
                                            </span>



                                            @if ($rekomendasi->tindakLanjut->count() == 0)
                                                <a href="{{ route('tindak-lanjut.create', $rekomendasi->id) }}"
                                                    class="btn btn-light btn-sm">


                                                    <i class="bi bi-plus"></i>
                                                    Tambah Tindak Lanjut


                                                </a>
                                            @endif


                                        </div>





                                        <div class="card-body">


                                            @forelse($rekomendasi->tindakLanjut as $tl)
                                                <div class="mb-2">

                                                    <strong>Status:</strong>

                                                    {{ $tl->status->nama_status ?? '-' }}

                                                </div>



                                                <div class="mb-2">

                                                    <strong>Narasi:</strong>

                                                    <p>
                                                        {{ $tl->narasi }}
                                                    </p>

                                                </div>



                                                <div class="row">


                                                    <div class="col-md-6">


                                                        <strong>
                                                            Nilai Pengembalian:
                                                        </strong>


                                                        <p>
                                                            Rp
                                                            {{ number_format($tl->nilai_pengembalian ?? 0, 0, ',', '.') }}
                                                        </p>


                                                    </div>




                                                    <div class="col-md-6">


                                                        <strong>
                                                            Nilai Setor Pajak:
                                                        </strong>


                                                        <p>
                                                            Rp
                                                            {{ number_format($tl->nilai_setor_pajak ?? 0, 0, ',', '.') }}
                                                        </p>


                                                    </div>


                                                </div>



                                                <div class="row mb-3">
                                                    <div class="col-md-6">


                                                        <strong>
                                                            Validator:
                                                        </strong>


                                                        {{ $tl->validator ?? '-' }}


                                                    </div>
                                                    <div class="col-md-6">


                                                        <strong>
                                                            Tanggal validasi:
                                                        </strong>


                                                        {{ $tl->tanggal_validasi ?? '-' }}


                                                    </div>
                                                </div>

                                                {{-- Dokumen Tindak Lanjut --}}

                                                <div class="mb-3">

                                                    <strong>
                                                        Dokumen Pendukung:
                                                    </strong>


                                                    <ul class="mt-2">


                                                        @forelse($tl->dokumen as $dok)
                                                            <li class="mb-1">


                                                                <a href="{{ asset('storage/' . $dok->path_file) }}"
                                                                    target="_blank" class="text-decoration-none">


                                                                    <i class="bi bi-file-earmark-text"></i>

                                                                    {{ $dok->nama_file }}


                                                                </a>


                                                                <small class="text-muted">

                                                                    ({{ $dok->tipe_file }})
                                                                </small>


                                                            </li>


                                                        @empty


                                                            <li class="text-muted">

                                                                Belum ada dokumen

                                                            </li>
                                                        @endforelse


                                                    </ul>


                                                </div>

                                                <div class="d-flex gap-2 mb-3">


                                                    <a href="{{ route('tindak-lanjut.edit', $tl->id) }}"
                                                        class="btn btn-warning btn-sm">

                                                        <i class="bi bi-pencil"></i>
                                                        Edit Tindak Lanjut

                                                    </a>





                                                    <form action="{{ route('tindak-lanjut.destroy', $tl->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Hapus tindak lanjut ini?')">


                                                        @csrf
                                                        @method('DELETE')


                                                        <button type="submit" class="btn btn-danger btn-sm">


                                                            <i class="bi bi-trash"></i>
                                                            Hapus Tindak Lanjut


                                                        </button>


                                                    </form>


                                                </div>



                                            @empty


                                                <span class="text-muted">
                                                    Belum ada tindak lanjut
                                                </span>
                                            @endforelse


                                        </div>


                                    </div>



                                </div>


                            @empty


                                <div class="text-muted">

                                    Belum ada rekomendasi

                                </div>
                            @endforelse



                        </div>


                    </div>





                @empty


                    <div class="text-center text-muted">

                        Belum ada temuan

                    </div>
                @endforelse



            </div>







        </div>


    @endsection
