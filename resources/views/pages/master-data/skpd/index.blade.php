@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Master Data SKPD
                </h4>

                <p class="text-muted mb-0">
                    Daftar Satuan Kerja Perangkat Daerah Kabupaten Ketapang
                </p>
            </div>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSkpd">

                <i class="bi bi-plus-circle"></i>

                Tambah SKPD

            </button>

        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button class="btn-close" data-bs-dismiss="alert"></button>

            </div>
        @endif

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle" id="dataTable">

                        <thead class="table-light text-center">

                            <tr>
                                <th width="5%">No</th>
                                <th>Wilayah Pengawasan</th>
                                <th>Nama SKPD</th>
                                <th width="10%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($skpds as $skpd)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $skpd->wilayah_pengawasan }}
                                    </td>

                                    <td>
                                        {{ $skpd->nama_skpd }}
                                    </td>

                                    <td class="text-center">

                                        @if ($skpd->status)
                                            <span class="badge bg-success">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Nonaktif
                                            </span>
                                        @endif

                                    </td>

                                    <td class="text-center">

                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editSkpd{{ $skpd->id }}">

                                            <i class="bi bi-pencil"></i>

                                        </button>

                                        <form action="{{ route('skpd.destroy', $skpd->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data SKPD ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editSkpd{{ $skpd->id }}" tabindex="-1">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <form action="{{ route('skpd.update', $skpd->id) }}" method="POST">

                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header bg-warning">

                                                    <h5 class="modal-title">

                                                        Edit SKPD

                                                    </h5>

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    </button>


                                                </div>

                                                <div class="modal-body">

                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            Nama SKPD
                                                        </label>

                                                        <input type="text" name="nama_skpd" class="form-control"
                                                            value="{{ $skpd->nama_skpd }}" required>

                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Wilayah Pengawasan
                                                        </label>

                                                        <input type="text" name="wilayah_pengawasan" class="form-control"
                                                            value="{{ old('wilayah_pengawasan', $skpd->wilayah_pengawasan ?? '') }}"
                                                            placeholder="Contoh: Kecamatan Delta Pawan">
                                                    </div>

                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            Status
                                                        </label>

                                                        <select name="status" class="form-select">

                                                            <option value="1" {{ $skpd->status ? 'selected' : '' }}>
                                                                Aktif
                                                            </option>

                                                            <option value="0" {{ !$skpd->status ? 'selected' : '' }}>
                                                                Nonaktif
                                                            </option>

                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">

                                                        Batal

                                                    </button>

                                                    <button class="btn btn-warning">

                                                        <i class="bi bi-save"></i>

                                                        Update

                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            @empty
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambahSkpd" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{ route('skpd.store') }}" method="POST">

                    @csrf

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah SKPD
                        </h5>

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Nama SKPD
                            </label>

                            <input type="text" name="nama_skpd" class="form-control" required>

                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Wilayah Pengawasan
                            </label>

                            <input type="text" name="wilayah_pengawasan" class="form-control" placeholder="Contoh: Kecamatan Delta Pawan">
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-secondary" data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button class="btn btn-primary">

                            <i class="bi bi-save"></i>

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
