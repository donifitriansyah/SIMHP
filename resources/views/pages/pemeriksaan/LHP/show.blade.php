@extends('layouts.backend')

@section('content')

    <div class="container-fluid py-4">

        {{-- Header --}} <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h4 class="fw-bold mb-1"> Detail Laporan Hasil Pemeriksaan </h4>

                <p class="text-muted mb-0"> Informasi lengkap laporan hasil pemeriksaan </p>

            </div>

            <div>

                <a href="{{ url()->previous() }}" class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>
                    Kembali

                </a>

                @auth
                    @if (auth()->user()->role == 'super_user')
                        <a href="{{ route('lhp.cetak', $lhp->id) }}" target="_blank" class="btn btn-danger">
                            <i class="bi bi-printer"></i>
                            Cetak PDF
                        </a>
                        <a href="{{ route('lhp.edit', $lhp->id) }}" class="btn btn-warning">

                            <i class="bi bi-pencil"></i> Edit LHP

                        </a>
                    @endif
                @endauth
                <div class="d-flex gap-2 mt-2">

                    @auth

                        {{-- Super User --}}
                        @if (auth()->user()->isSuperUser())
                            <a href="{{ route('lhp.edit', $lhp->id) }}" class="btn btn-warning">

                                <i class="bi bi-pencil"></i>
                                Edit LHP

                            </a>


                            {{-- User Entry --}}
                        @elseif(auth()->user()->isUserEntry())
                            @if ($editRequest && $editRequest->status == 'approved')
                                <a href="{{ route('lhp.edit', $lhp->id) }}" class="btn btn-warning">

                                    <i class="bi bi-pencil"></i>
                                    Edit LHP

                                </a>


                                <form action="{{ route('edit-requests.complete', $editRequest->id) }}" method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit" class="btn btn-success"
                                        onclick="return confirm('Selesaikan proses edit?')">

                                        <i class="bi bi-check-circle"></i>
                                        Selesai Edit

                                    </button>

                                </form>
                            @elseif($editRequest && $editRequest->status == 'pending')
                                <button class="btn btn-secondary" disabled>

                                    <i class="bi bi-clock"></i>
                                    Menunggu Persetujuan Admin

                                </button>
                            @else
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#requestEditModal{{ $lhp->id }}">

                                    <i class="bi bi-pencil"></i>
                                    Minta Akses Edit

                                </button>
                            @endif
                        @endif

                    @endauth

                </div>


                <div class="modal fade" id="requestEditModal{{ $lhp->id }}" tabindex="-1">

                    <div class="modal-dialog">

                        <form action="{{ route('edit-requests.store') }}" method="POST">

                            @csrf

                            <input type="hidden" name="lhp_id" value="{{ $lhp->id }}">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title">

                                        Permintaan Akses Edit

                                    </h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                </div>

                                <div class="modal-body">

                                    <div class="alert alert-warning">

                                        Setelah LHP disimpan, data tidak dapat diedit kembali.
                                        Jika terdapat kesalahan, silakan ajukan permintaan akses edit
                                        kepada Administrator.

                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label">

                                            Alasan Permintaan Edit <span class="text-danger">*</span>

                                        </label>

                                        <textarea name="alasan" class="form-control" rows="4" required
                                            placeholder="Contoh: Salah memasukkan nilai temuan, salah memilih auditee, dll."></textarea>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                                        Batal

                                    </button>

                                    <button type="submit" class="btn btn-primary">

                                        Kirim Permintaan

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>


            </div>

        </div>

        {{-- Informasi LHP --}}
        <div class="card shadow-sm border-0 mb-4">

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

                        <h6> Rp {{ number_format($lhp->jumlah_dana_diawasi, 2, ',', '.') }} </h6>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-muted"> Instansi Pemeriksa </label>

                        <h6>{{ $lhp->instansi_pemeriksa_label }}</h6>

                    </div>

                </div>

            </div>

        </div>

        {{-- Entitas Pemeriksaan --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-info text-white">

                <h5 class="mb-0"> Entitas Pemeriksaan </h5>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">

                        <label class="text-muted"> Irban </label>

                        <h6> {{ $lhp->irban->nama_irban ?? '-' }} </h6>

                    </div>


                    @if ($jenis == 'internal')
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
                    @endif
                    @if ($jenis == 'eksternal')
                        <div class="col-md-4">

                            <label class="text-muted"> Nama Pejabat </label>

                            <h6> {{ $lhp->nama_pejabat_eksternal ?? '-' }} </h6>

                        </div>
                    @endif

                    <div class="col-md-4 ">

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

        {{-- Temuan Pemeriksaan --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0 fw-bold"> <i class="bi bi-search"></i> Temuan Pemeriksaan </h5>

                @if (!auth()->user()->isUserView() && $lhp->status_proses != 'nihil')
                    <a href="{{ route('temuan.create', $lhp->id) }}" class="btn btn-primary">
                        <i class="bi bi-plus"></i>
                        Tambah Temuan
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

                                                <div class="col-md-12">

                                                    <label class="text-muted"> Nama Pelaku </label>

                                                    <p> {{ $temuan->nama_pelaku ?? '-' }} </p>

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

                                                @if ($temuan->detailFinansial->count())
                                                    <div class="col-md-12 mt-3">

                                                        <label class="text-muted fw-bold">
                                                            Detail Temuan Finansial
                                                        </label>

                                                        <table class="table table-bordered table-sm mt-2">

                                                            <thead class="table-light">

                                                                <tr>

                                                                    <th width="60">No</th>

                                                                    <th>Jenis</th>

                                                                    <th>Nama</th>

                                                                    <th class="text-end">Nilai Temuan</th>

                                                                </tr>

                                                            </thead>

                                                            <tbody>

                                                                @foreach ($temuan->detailFinansial as $detail)
                                                                    <tr>

                                                                        <td>{{ $loop->iteration }}</td>

                                                                        <td>
                                                                            {{ $detail->jenis == 'pns' ? 'PNS' : 'Penyedia' }}
                                                                        </td>

                                                                        <td>
                                                                            {{ $detail->jenis == 'pns' ? $detail->nama_pihak : $detail->nama_penyedia }}
                                                                        </td>

                                                                        <td class="text-end">
                                                                            Rp
                                                                            {{ number_format($detail->nilai_temuan, 0, ',', '.') }}
                                                                        </td>


                                                                    </tr>
                                                                @endforeach

                                                            </tbody>

                                                            <tfoot>

                                                                <tr class="table-secondary">

                                                                    <th colspan="3" class="text-end">
                                                                        Total
                                                                    </th>

                                                                    <th class="text-end">

                                                                        Rp
                                                                        {{ number_format($temuan->detailFinansial->sum('nilai_temuan'), 0, ',', '.') }}

                                                                    </th>

                                                                </tr>

                                                            </tfoot>

                                                        </table>

                                                    </div>
                                                @endif



                                            </div>
                                            @auth

                                                @if (auth()->user()->canEditLhp($lhp))
                                                    <a href="{{ route('temuan.edit', $temuan->id) }}"
                                                        class="btn btn-warning btn-sm">

                                                        <i class="fas fa-edit"></i>
                                                        Edit Temuan

                                                    </a>
                                                @endif


                                                @if (auth()->user()->role == 'super_user')
                                                    <form action="{{ route('temuan.destroy', $temuan->id) }}" method="POST"
                                                        class="d-inline" onsubmit="return confirm('Hapus temuan ini?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-sm btn-danger">

                                                            <i class="bi bi-trash"></i>
                                                            Hapus

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

                                            {{-- Tombol Edit Rekomendasi --}}
                                            {{-- Edit rekomendasi --}}
                                            @if (auth()->user()->canEditLhp($lhp))
                                                @if ($temuan->rekomendasis->count() > 0)
                                                    <a href="{{ route('rekomendasi.edit', $temuan->rekomendasis->first()->id) }}"
                                                        class="btn btn-warning btn-sm">

                                                        <i class="fas fa-edit"></i>
                                                        Edit Rekomendasi

                                                    </a>
                                                @endif
                                            @endif


                                            {{-- Tombol Tambah Rekomendasi hanya jika belum ada --}}
                                            @if (in_array(auth()->user()->role, ['super_user', 'user_entry']))
                                                @if ($temuan->rekomendasis->count() == 0)
                                                    <a href="{{ route('rekomendasi.create', $temuan->id) }}"
                                                        class="btn btn-primary btn-sm">

                                                        <i class="bi bi-plus"></i>
                                                        Tambah Rekomendasi

                                                    </a>
                                                @endif
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

                                                    @if (in_array(auth()->user()->role, ['super_user', 'user_entry']))
                                                        @php
                                                            $tindakLanjutTerakhir = $rekomendasi->tindakLanjut
                                                                ->sortByDesc('created_at')
                                                                ->first();
                                                        @endphp


                                                        @if (!$tindakLanjutTerakhir || $tindakLanjutTerakhir->status_id != 3)
                                                            <a href="{{ route('tindak-lanjut.create', $rekomendasi->id) }}"
                                                                class="btn btn-success btn-sm">

                                                                <i class="bi bi-plus"></i>
                                                                Tambah

                                                            </a>
                                                        @else
                                                            <span class="badge bg-success">
                                                                Selesai
                                                            </span>
                                                        @endif
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
                                                            @php
                                                                $tindakLanjutTerakhir = $rekomendasi->tindakLanjut
                                                                    ->sortByDesc('created_at')
                                                                    ->first();
                                                            @endphp


                                                            @if (!$tindakLanjutTerakhir || $tindakLanjutTerakhir->status_id != 3)
                                                                <a href="{{ route('tindak-lanjut.create', $rekomendasi->id) }}"
                                                                    class="btn btn-success btn-sm">

                                                                    <i class="bi bi-plus"></i>

                                                                    Tambah

                                                                </a>
                                                            @else
                                                                <span class="badge bg-success">
                                                                    Selesai
                                                                </span>
                                                            @endif
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
                                                                        {{ number_format($tl->nilai_pengembalian ?? 0, 2, ',', '.') }}

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

                                                                @if (auth()->user()->canEditLhp($lhp))
                                                                    @php
                                                                        $tindakLanjutTerakhir = $rekomendasi->tindakLanjut
                                                                            ->sortByDesc('created_at')
                                                                            ->first();
                                                                    @endphp


                                                                    @if ($tindakLanjutTerakhir)
                                                                        <a href="{{ route('tindak-lanjut.edit', $tindakLanjutTerakhir->id) }}"
                                                                            class="btn btn-warning btn-sm">

                                                                            <i class="fas fa-edit"></i>
                                                                            Edit TL

                                                                        </a>
                                                                    @endif
                                                                @endif



                                                                @if (auth()->user()->role == 'super_user')
                                                                    @php
                                                                        $tindakLanjutTerakhir = $rekomendasi->tindakLanjut
                                                                            ->sortByDesc('created_at')
                                                                            ->first();
                                                                    @endphp


                                                                    @if (!$tindakLanjutTerakhir || $tindakLanjutTerakhir->status_id != 3)
                                                                        <a href="{{ route('tindak-lanjut.create', $rekomendasi->id) }}"
                                                                            class="btn btn-success btn-sm">

                                                                            <i class="bi bi-plus"></i>
                                                                            Tambah

                                                                        </a>
                                                                    @else
                                                                        <span class="badge bg-success">
                                                                            Selesai
                                                                        </span>
                                                                    @endif
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
