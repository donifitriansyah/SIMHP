@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('import_errors'))
            <div class="alert alert-warning">

                <strong>Beberapa data gagal diimport:</strong>

                <ul class="mb-0">

                    @foreach (session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Data Pegawai
                </h5>



                <!-- Modal Tambah -->
                <div class="modal fade" id="modalTambah" tabindex="-1">

                    <div class="modal-dialog modal-lg">

                        <div class="modal-content">

                            <form action="{{ route('pegawai.store') }}" method="POST">

                                @csrf

                                <div class="modal-header">

                                    <h5 class="modal-title">
                                        Tambah Pegawai
                                    </h5>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                    </button>

                                </div>

                                <div class="modal-body">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Nama Pegawai
                                            </label>

                                            <input type="text" name="nama" class="form-control" required>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                NIP
                                            </label>

                                            <input type="text" name="nip" class="form-control" required>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Jabatan
                                            </label>

                                            <input type="text" name="jabatan" class="form-control"
                                                placeholder="Masukkan jabatan" required>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label">
                                                Golongan
                                            </label>

                                            <input type="text" name="golongan" class="form-control"
                                                placeholder="Contoh : IV/a">

                                        </div>

                                        <div class="col-md-12 mb-3">

                                            <label class="form-label">
                                                Satuan Kerja Perangkat Daerah (SKPD)
                                            </label>

                                            <select name="skpd_id" class="form-select">

                                                <option value="">
                                                    -- Pilih SKPD --
                                                </option>

                                                @foreach ($skpds as $skpd)
                                                    <option value="{{ $skpd->id }}">

                                                        {{ $skpd->nama_skpd }}

                                                    </option>
                                                @endforeach

                                            </select>

                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                                        Batal

                                    </button>

                                    <button type="submit" class="btn btn-primary">

                                        <i class="bi bi-save"></i>

                                        Simpan

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Pegawai
                    </button>

                    <a href="{{ route('pegawai.template') }}" class="btn btn-success">
                        <i class="bi bi-download"></i>
                        Download Template CSV
                    </a>

                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importPegawai">
                        <i class="bi bi-upload"></i>
                        Import CSV
                    </button>

                    <div class="modal fade" id="importPegawai">

                        <div class="modal-dialog">

                            <form action="{{ route('pegawai.import') }}" method="POST" enctype="multipart/form-data">

                                @csrf

                                <div class="modal-content">

                                    <div class="modal-header bg-primary text-white">

                                        <h5 class="modal-title">
                                            Import Data Pegawai
                                        </h5>

                                        <button class="btn-close" data-bs-dismiss="modal">
                                        </button>

                                    </div>

                                    <div class="modal-body">

                                        <div class="alert alert-info">

                                            <strong>Petunjuk :</strong>

                                            <ol class="mb-0">

                                                <li>Download template CSV.</li>

                                                <li>Isi data menggunakan Microsoft Excel.</li>

                                                <li>Pilih <b>Save As → CSV UTF-8 (*.csv)</b>.</li>

                                                <li>Upload file tersebut.</li>

                                            </ol>

                                        </div>

                                        <div class="mb-3">

                                            <label>File CSV</label>

                                            <input type="file" name="file" class="form-control" accept=".csv"
                                                required>

                                        </div>

                                    </div>

                                    <div class="modal-footer">

                                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                                            Batal
                                        </button>

                                        <button class="btn btn-primary">

                                            <i class="bi bi-upload"></i>

                                            Import

                                        </button>

                                    </div>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle" id="dataTable">

                        <thead class="table-light text-center">

                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
                                <th>Golongan</th>
                                <th>Satuan Kerja Perangkat Daerah</th>
                                <th width="140">Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($pegawais as $pegawai)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>{{ $pegawai->nama }}</td>

                                    <td>{{ $pegawai->nip }}</td>

                                    <td>{{ $pegawai->jabatan }}</td>

                                    <td>{{ $pegawai->golongan ?? '-' }}</td>

                                    <td>
                                        {{ $pegawai->skpd->nama_skpd ?? '-' }}
                                    </td>

                                    <td class="text-center">

                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editPegawai{{ $pegawai->id }}">

                                            <i class="bi bi-pencil"></i>

                                        </button>

                                        <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin menghapus data ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editPegawai{{ $pegawai->id }}" tabindex="-1"
                                    aria-labelledby="editPegawaiLabel{{ $pegawai->id }}" aria-hidden="true">

                                    <div class="modal-dialog modal-lg">

                                        <div class="modal-content">

                                            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">

                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header">

                                                    <h5 class="modal-title" id="editPegawaiLabel{{ $pegawai->id }}">

                                                        Edit Pegawai

                                                    </h5>

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                    </button>

                                                </div>

                                                <div class="modal-body">

                                                    <div class="row">

                                                        <div class="col-md-6 mb-3">

                                                            <label class="form-label">
                                                                Nama Pegawai
                                                            </label>

                                                            <input type="text" name="nama" class="form-control"
                                                                value="{{ $pegawai->nama }}" required>

                                                        </div>

                                                        <div class="col-md-6 mb-3">

                                                            <label class="form-label">
                                                                NIP
                                                            </label>

                                                            <input type="text" name="nip" class="form-control"
                                                                value="{{ $pegawai->nip }}" required>

                                                        </div>

                                                        <div class="col-md-6 mb-3">

                                                            <label class="form-label">
                                                                Jabatan
                                                            </label>

                                                            <input type="text" name="jabatan" class="form-control"
                                                                value="{{ $pegawai->jabatan }}" required>

                                                        </div>

                                                        <div class="col-md-6 mb-3">

                                                            <label class="form-label">
                                                                Golongan
                                                            </label>

                                                            <input type="text" name="golongan" class="form-control"
                                                                value="{{ $pegawai->golongan }}">

                                                        </div>

                                                        <div class="col-md-12 mb-3">

                                                            <label class="form-label">
                                                                Satuan Kerja Perangkat Daerah (SKPD)
                                                            </label>

                                                            <select name="skpd_id" class="form-select">

                                                                <option value="">
                                                                    -- Pilih SKPD --
                                                                </option>

                                                                @foreach ($skpds as $skpd)
                                                                    <option value="{{ $skpd->id }}"
                                                                        {{ $pegawai->skpd_id == $skpd->id ? 'selected' : '' }}>

                                                                        {{ $skpd->nama_skpd }}

                                                                    </option>
                                                                @endforeach

                                                            </select>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">

                                                        Batal

                                                    </button>

                                                    <button type="submit" class="btn btn-primary">

                                                        <i class="bi bi-check-circle"></i>

                                                        Update

                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <tr>

                                    <td colspan="7" class="text-center">

                                        Belum ada data.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
