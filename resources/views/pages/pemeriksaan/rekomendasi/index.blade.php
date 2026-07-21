@extends('layouts.backend')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Data Rekomendasi
                </h4>

                <p class="text-muted mb-0">
                    Daftar seluruh rekomendasi hasil pemeriksaan
                </p>
            </div>

            <a href="{{ route('dashboard', ['jenis' => $jenis]) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>

        </div>

        {{-- Filter --}}
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <form method="GET">

                    <input type="hidden" name="jenis" value="{{ $jenis }}">

                    <div class="row">

                        @if (!auth()->user()->isUserView())
                            <div class="col-md-4">

                                <label class="form-label">
                                    Irban
                                </label>

                                <select name="irban_id" class="form-select">

                                    <option value="">
                                        Semua Irban
                                    </option>

                                    @foreach ($irbans as $irban)
                                        <option value="{{ $irban->id }}"
                                            {{ request('irban_id') == $irban->id ? 'selected' : '' }}>

                                            {{ $irban->nama_irban }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>
                        @endif

                        <div class="col-md-2 d-flex align-items-end">

                            <button class="btn btn-primary w-100">

                                <i class="bi bi-search"></i>

                                Filter

                            </button>

                        </div>

                        <div class="col-md-2 d-flex align-items-end">

                            <a href="{{ route('rekomendasi.index', ['jenis' => $jenis]) }}" class="btn btn-secondary w-100">

                                Reset

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        {{-- Table --}}
        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table id="dataTable" class="table table-bordered table-striped align-middle">

                        <thead class="table-primary text-center">

                            <tr>

                                <th width="50">No</th>

                                <th>Nomor LHP</th>

                                <th>Irban</th>

                                <th>Auditee</th>

                                <th>Rekomendasi</th>

                                <th width="180">
                                    Nilai Finansial
                                </th>

                                <th width="180">
                                    Nilai Pajak
                                </th>

                                <th width="100">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($rekomendasis as $rekomendasi)
                                <tr>

                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $rekomendasi->temuan->lhp->nomor_lhp }}
                                    </td>

                                    <td>

                                        {{ $rekomendasi->temuan->lhp->irban->nama_irban ?? '-' }}

                                    </td>

                                    <td>

                                        {{ $rekomendasi->temuan->lhp->auditee->nama_dinas ?? '-' }}

                                    </td>

                                    <td>

                                        {{ Str::limit($rekomendasi->uraian_rekomendasi, 100) }}

                                    </td>

                                    <td class="text-end">

                                        Rp
                                        {{ number_format($rekomendasi->nilai_finansial ?? 0, 0, ',', '.') }}

                                    </td>

                                    <td class="text-end">

                                        Rp
                                        {{ number_format($rekomendasi->nilai_pajak ?? 0, 0, ',', '.') }}

                                    </td>

                                    <td class="text-center">

                                        {{-- Detail LHP --}}
                                        <a href="{{ route('lhp.show', $rekomendasi->temuan->lhp_id) }}"
                                            class="btn btn-primary btn-sm mb-1">

                                            <i class="bi bi-eye"></i>

                                        </a>


                                        @auth

                                            {{-- Edit --}}
                                            @if (auth()->user()->canEditLhp($rekomendasi->temuan->lhp))
                                                <a href="{{ route('rekomendasi.edit', $rekomendasi->id) }}"
                                                    class="btn btn-warning btn-sm mb-1">

                                                    <i class="bi bi-pencil"></i>

                                                </a>
                                            @endif


                                            {{-- Hapus hanya Super User --}}
                                            @if (auth()->user()->isSuperUser())
                                                <form action="{{ route('rekomendasi.destroy', $rekomendasi->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus rekomendasi ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm mb-1">

                                                        <i class="bi bi-trash"></i>

                                                    </button>

                                                </form>
                                            @endif

                                        @endauth

                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#tableRekomendasi').DataTable({

                pageLength: 10,

                responsive: true,

                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
                }

            });

        });
    </script>
@endpush
