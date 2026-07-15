@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Data Pegawai
                </h5>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Pegawai
                </button>

                <div class="modal fade" id="modalTambah">

                    <div class="modal-dialog modal-lg">

                        <div class="modal-content">

                            <form action="{{ route('pegawai.store') }}" method="POST">

                                @csrf

                                <div class="modal-header">

                                    <h5>Tambah Pegawai</h5>

                                    <button class="btn-close" data-bs-dismiss="modal"></button>

                                </div>

                                <div class="modal-body">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label>Nama</label>

                                            <input type="text" name="nama" class="form-control" required>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label>NIP</label>

                                            <input type="text" name="nip" class="form-control" required>

                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Jabatan</label>

                                            <select name="jabatan" class="form-select" required>

                                                <option value="">Pilih Jabatan</option>

                                                @php
                                                    $jabatans = [
                                                        'Inspektur Kabupaten Ketapang',
                                                        'Sekretaris',
                                                        'Inspektur Pembantu I',
                                                        'Inspektur Pembantu II',
                                                        'Inspektur Pembantu III',
                                                        'Inspektur Pembantu IV',
                                                    ];
                                                @endphp

                                                @foreach ($jabatans as $jabatan)
                                                    <option value="{{ $jabatan }}"
                                                        {{ in_array($jabatan, $jabatanTerpakai) ? 'disabled' : '' }}>

                                                        {{ $jabatan }}

                                                        {{ in_array($jabatan, $jabatanTerpakai) ? '(Sudah Dipakai)' : '' }}

                                                    </option>
                                                @endforeach

                                            </select>

                                        </div>

                                        <div class="col-md-6 mb-3">

                                            <label>Golongan</label>

                                            <input type="text" name="golongan" class="form-control">

                                        </div>

                                        <div class="col-md-12">

                                            <label>Irban</label>

                                            <select name="irban_id" class="form-select">

                                                <option value="">
                                                    -
                                                </option>

                                                @foreach ($irbans as $irban)
                                                    <option value="{{ $irban->id }}">
                                                        {{ $irban->nama_irban }}
                                                    </option>
                                                @endforeach

                                            </select>

                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button class="btn btn-secondary" data-bs-dismiss="modal">

                                        Batal

                                    </button>

                                    <button class="btn btn-primary">

                                        Simpan

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light text-center">

                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
                                <th>Golongan</th>
                                <th>Irban</th>
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
                                        {{ $pegawai->irban->nama_irban ?? '-' }}
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

                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>

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

                                                        <div class="mb-3">
                                                            <label class="form-label">Jabatan</label>

                                                            <select name="jabatan" class="form-select" required>

                                                                @php
                                                                    $jabatans = [
                                                                        'Inspektur Kabupaten Ketapang',
                                                                        'Sekretaris',
                                                                        'Inspektur Pembantu I',
                                                                        'Inspektur Pembantu II',
                                                                        'Inspektur Pembantu III',
                                                                        'Inspektur Pembantu IV',
                                                                    ];
                                                                @endphp

                                                                @foreach ($jabatans as $jabatan)
                                                                    @php
                                                                        $disabled =
                                                                            in_array($jabatan, $jabatanTerpakai) &&
                                                                            $pegawai->jabatan != $jabatan;
                                                                    @endphp

                                                                    <option value="{{ $jabatan }}"
                                                                        {{ $pegawai->jabatan == $jabatan ? 'selected' : '' }}
                                                                        {{ $disabled ? 'disabled' : '' }}>

                                                                        {{ $jabatan }}

                                                                        {{ $disabled ? '(Sudah Dipakai)' : '' }}

                                                                    </option>
                                                                @endforeach

                                                            </select>

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
                                                                Irban
                                                            </label>

                                                            <select name="irban_id" class="form-select">

                                                                <option value="">
                                                                    -
                                                                </option>

                                                                @foreach ($irbans as $irban)
                                                                    <option value="{{ $irban->id }}"
                                                                        {{ $pegawai->irban_id == $irban->id ? 'selected' : '' }}>

                                                                        {{ $irban->nama_irban }}

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
