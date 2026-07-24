@extends('layouts.backend')

@section('title', 'Penandatangan Laporan')

@section('content')

    <div class="container-fluid">

        <div class="card shadow-sm">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="bi bi-pencil-square"></i>
                    Master Penandatangan Laporan
                </h5>



                @if ($bisaTambah)
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle"></i> Tambah Data
                    </button>
                @endif

                <!-- Modal Tambah -->
                <div class="modal fade" id="modalTambah" tabindex="-1">

                    <div class="modal-dialog">

                        <div class="modal-content">

                            <form action="{{ route('penandatangan.store') }}" method="POST">

                                @csrf

                                <div class="modal-header bg-primary text-white">

                                    <h5 class="modal-title">

                                        Tambah Penandatangan

                                    </h5>

                                    <button type="button" class="btn-close btn-close-white"
                                        data-bs-dismiss="modal"></button>

                                </div>

                                <div class="modal-body">


                                    <div class="mb-3">

                                        <label class="form-label">
                                            Nama
                                        </label>

                                        <input type="text" name="nama" class="form-control" required>

                                    </div>

                                    <div class="mb-3">
                                        <label>Jabatan</label>

                                        <select name="jabatan" class="form-select" required>

                                            <option value="">-- Pilih Jabatan --</option>

                                            @php
                                                $jabatanTerpakai = $data->pluck('jabatan')->toArray();
                                            @endphp

                                            <option value="Inspektur"
                                                {{ in_array('Inspektur', $jabatanTerpakai) ? 'disabled' : '' }}>
                                                Inspektur
                                            </option>

                                            <option value="Sekretaris"
                                                {{ in_array('Sekretaris', $jabatanTerpakai) ? 'disabled' : '' }}>
                                                Sekretaris
                                            </option>

                                        </select>
                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Golongan
                                        </label>

                                        <input type="text" name="golongan" class="form-control">

                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label">
                                            NIP
                                        </label>

                                        <input type="text" name="nip" class="form-control">

                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Status
                                        </label>

                                        <select name="status" class="form-select">

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

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

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


            </div>



            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="table-responsive">

                    <table class="table table-bordered table-striped align-middle" id="dataTable">

                        <thead class="table-light">

                            <tr>

                                <th width="60">No</th>

                                <th>Nama</th>

                                <th>Jabatan</th>

                                <th>Golongan</th>

                                <th>NIP</th>

                                <th>Status</th>

                                <th width="120">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($data as $item)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $item->nama }}
                                    </td>

                                    <td>
                                        {{ $item->jabatan }}
                                    </td>

                                    <td>
                                        {{ $item->golongan }}
                                    </td>

                                    <td>
                                        {{ $item->nip }}
                                    </td>

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

                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#edit{{ $item->id }}">

                                            <i class="bi bi-pencil"></i>

                                            Edit

                                        </button>

                                    </td>

                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="edit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <form action="{{ route('penandatangan.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title">
                                                        Edit Penandatangan
                                                    </h5>

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                    </button>
                                                </div>

                                                <div class="modal-body">

                                                    <div class="mb-3">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" name="nama" class="form-control"
                                                            value="{{ $item->nama }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Jabatan</label>

                                                        <input type="text" class="form-control"
                                                            value="{{ $item->jabatan }}" readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Golongan</label>
                                                        <input type="text" name="golongan" class="form-control"
                                                            value="{{ $item->golongan }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">NIP</label>
                                                        <input type="text" name="nip" class="form-control"
                                                            value="{{ $item->nip }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>

                                                        <select name="status" class="form-select">

                                                            <option value="1" {{ $item->status ? 'selected' : '' }}>
                                                                Aktif
                                                            </option>

                                                            <option value="0" {{ !$item->status ? 'selected' : '' }}>
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

                                                    <button type="submit" class="btn btn-warning">
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



@endsection
