@extends('layouts.backend')

@section('content')
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                Temuan berdasarkan PNS
            </h5>
        </div>

        <div class="card-body">


            <form method="GET" action="{{ route('laporan.pns.temuan') }}" class="row g-3 mb-4">

                <div class="col-md-3">

                    <label class="form-label">
                        Jenis Pemeriksaan
                    </label>

                    <select name="jenis" class="form-select" required>

                        <option value="internal" {{ request('jenis', 'internal') == 'internal' ? 'selected' : '' }}>
                            Internal
                        </option>

                        <option value="eksternal" {{ request('jenis') == 'eksternal' ? 'selected' : '' }}>
                            Eksternal
                        </option>

                    </select>

                </div>


                <div class="col-md-2">

                    <label class="form-label">
                        Tanggal Awal
                    </label>

                    <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">

                </div>


                <div class="col-md-2">

                    <label class="form-label">
                        Tanggal Akhir
                    </label>

                    <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">

                </div>


                <div class="col-md-2 d-flex align-items-end">

                    <button class="btn btn-primary w-100">

                        <i class="bi bi-search"></i>
                        Tampilkan

                    </button>

                </div>


                <div class="col-md-2 d-flex align-items-end">

                    <a href="{{ route('laporan.pns.temuan') }}" class="btn btn-secondary w-100">

                        Reset

                    </a>

                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('laporan.pns.temuan.cetak', request()->query()) }}" target="_blank"
                    class="btn btn-success w-100">

                    <i class="bi bi-printer"></i>
                    Cetak

                </a>

                </div>


            </form>

            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Nomor LHP</th>

                            <th>Nama PNS</th>

                            @if ($jenis == 'internal')
                                <th>Jabatan</th>

                                <th>Instansi</th>
                            @endif

                            <th>Jumlah Temuan</th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach ($lhps as $lhp)
                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $lhp->nomor_lhp }}
                                </td>


                                <td>

                                    @if ($lhp->instansi_pemeriksa == 'Itkab')
                                        {{ $lhp->pejabatAuditee->nama ?? '-' }}
                                    @else
                                        {{ $lhp->nama_pejabat_eksternal ?? '-' }}
                                    @endif

                                </td>

                                @if ($jenis == 'internal')
                                    <td>
                                        {{ $lhp->pejabatAuditee->jenis_jabatan ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $lhp->auditee->nama_dinas ?? '-' }}
                                    </td>
                                @endif




                                <td>
                                    {{ $lhp->temuans->count() }}
                                </td>


                            </tr>
                        @endforeach


                    </tbody>


                </table>

            </div>

        </div>
    @endsection
