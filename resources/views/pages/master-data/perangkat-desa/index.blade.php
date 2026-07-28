@extends('layouts.backend')

@section('title', 'Perangkat Desa')

@section('content')

    <div class="container-fluid">

        <div class="card shadow-sm">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="bi bi-building"></i>
                    Data Perangkat Desa
                </h5>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Data
                </button>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle" id="dataTable">

                        <thead class="table-light text-center">

                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Desa</th>
                                <th>Kecamatan</th>
                                <th width="10%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($perangkatDesa as $item)

                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>{{ $item->nama }}</td>

                                    <td>{{ $item->jabatan }}</td>

                                    <td>{{ $item->desa }}</td>

                                    <td>{{ $item->kecamatan ?? '-' }}</td>

                                    <td class="text-center">

                                        @if ($item->status)
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

                                        <button
                                            class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $item->id }}">

                                            <i class="bi bi-pencil"></i>

                                        </button>

                                        <form action="{{ route('perangkat-desa.destroy', $item->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Hapus data ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                                {{-- Modal Edit --}}

                                <div class="modal fade" id="edit{{ $item->id }}" tabindex="-1">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <form action="{{ route('perangkat-desa.update', $item->id) }}"
                                                method="POST">

                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header bg-warning">

                                                    <h5 class="modal-title">

                                                        Edit Perangkat Desa

                                                    </h5>

                                                    <button type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal">
                                                    </button>

                                                </div>

                                                <div class="modal-body">

                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            Nama
                                                        </label>

                                                        <input type="text"
                                                            name="nama"
                                                            class="form-control"
                                                            value="{{ $item->nama }}"
                                                            required>

                                                    </div>

                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            Jabatan
                                                        </label>

                                                        <input type="text"
                                                            name="jabatan"
                                                            class="form-control"
                                                            value="{{ $item->jabatan }}"
                                                            required>

                                                    </div>

                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            Desa
                                                        </label>

                                                        <input type="text"
                                                            name="desa"
                                                            class="form-control"
                                                            value="{{ $item->desa }}"
                                                            required>

                                                    </div>

                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            Kecamatan
                                                        </label>

                                                        <input type="text"
                                                            name="kecamatan"
                                                            class="form-control"
                                                            value="{{ $item->kecamatan }}">

                                                    </div>

                                                    <div class="mb-3">

                                                        <label class="form-label">
                                                            Status
                                                        </label>

                                                        <select name="status"
                                                            class="form-select">

                                                            <option value="1"
                                                                {{ $item->status ? 'selected' : '' }}>
                                                                Aktif
                                                            </option>

                                                            <option value="0"
                                                                {{ !$item->status ? 'selected' : '' }}>
                                                                Nonaktif
                                                            </option>

                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="modal-footer">

                                                    <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">

                                                        Batal

                                                    </button>

                                                    <button class="btn btn-warning">

                                                        <i class="bi bi-check-circle"></i>

                                                        Update

                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    {{-- Modal Tambah --}}

    <div class="modal fade" id="modalTambah" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{ route('perangkat-desa.store') }}" method="POST">

                    @csrf

                    <div class="modal-header bg-primary text-white">

                        <h5 class="modal-title">

                            Tambah Perangkat Desa

                        </h5>

                        <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">

                        </button>

                    </div>

                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">

                                Nama

                            </label>

                            <input type="text"
                                name="nama"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Jabatan

                            </label>

                            <input type="text"
                                name="jabatan"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Desa

                            </label>

                            <input type="text"
                                name="desa"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Kecamatan

                            </label>

                            <input type="text"
                                name="kecamatan"
                                class="form-control">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Status

                            </label>

                            <select name="status"
                                class="form-select">

                                <option value="1">
                                    Aktif
                                </option>

                                <option value="0">
                                    Nonaktif
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

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

