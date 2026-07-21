@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Data Temuan
                </h4>

                <p class="text-muted mb-0">
                    Menampilkan seluruh data temuan hasil pemeriksaan.
                </p>
            </div>

        </div>

        {{-- Filter --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <form method="GET">

                    <div class="row">

                        <div class="col-md-3">

                            <label class="form-label">
                                Irban
                            </label>

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

                        <div class="col-md-3">

                            <label class="form-label">
                                Jenis Pemeriksaan
                            </label>

                            <select name="jenis" class="form-select">

                                <option value="internal" {{ request('jenis') == 'internal' ? 'selected' : '' }}>
                                    Internal
                                </option>

                                <option value="eksternal" {{ request('jenis') == 'eksternal' ? 'selected' : '' }}>
                                    Eksternal
                                </option>

                            </select>

                        </div>

                        <div class="col-md-2 d-grid">

                            <label class="form-label">&nbsp;</label>

                            <button class="btn btn-primary">

                                <i class="bi bi-search"></i>

                                Cari

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- Table --}}
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <strong>

                    Daftar Temuan

                </strong>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle mb-0" id="dataTable">

                        <thead class="table-primary text-center">

                            <tr>

                                <th width="50">
                                    No
                                </th>

                                <th>
                                    Nomor LHP
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Irban
                                </th>

                                <th>
                                    Auditee
                                </th>

                                <th>
                                    Uraian Temuan
                                </th>

                                <th>
                                    Nilai Kerugian
                                </th>

                                <th>
                                    Rekomendasi
                                </th>

                                <th width="180">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($temuans as $temuan)
                                <tr>

                                    <td class="text-center">

                                        {{ $loop->iteration }}

                                    </td>

                                    <td>

                                        {{ $temuan->lhp->nomor_lhp }}

                                    </td>

                                    <td>

                                        {{ \Carbon\Carbon::parse($temuan->lhp->tanggal_lhp)->format('d-m-Y') }}

                                    </td>

                                    <td>

                                        {{ $temuan->lhp->irban->nama_irban ?? '-' }}

                                    </td>

                                    <td>

                                        {{ $temuan->lhp->auditee->nama_dinas ?? '-' }}

                                    </td>

                                    <td>

                                        {{ \Illuminate\Support\Str::limit($temuan->uraian_temuan, 70) }}

                                    </td>

                                    <td class="text-end">

                                        Rp
                                        {{ number_format($temuan->nilai_kerugian, 0, ',', '.') }}

                                    </td>

                                    <td class="text-center">

                                        <span class="badge bg-success">

                                            {{ $temuan->rekomendasis->count() }}

                                        </span>

                                    </td>

                                    <td class="text-center">

                                        <a href="{{ route('lhp.show', $temuan->lhp_id) }}" class="btn btn-info btn-sm">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                        @if (auth()->user()->canEditLhp($temuan->lhp))
                                            <a href="{{ route('temuan.edit', $temuan->id) }}"
                                                class="btn btn-warning btn-sm">

                                                <i class="bi bi-pencil"></i>

                                            </a>
                                        @endif

                                        @if (auth()->user()->isSuperUser())
                                            <form action="{{ route('temuan.destroy', $temuan->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Hapus temuan?')">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>
                                        @endif

                                    </td>

                                </tr>

                            @empty
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
