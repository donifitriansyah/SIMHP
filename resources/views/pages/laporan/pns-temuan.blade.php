@extends('layouts.backend')

@section('content')
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                Temuan berdasarkan PNS
            </h5>
        </div>

        <div class="card-body">

            <div class="col-md-2 d-flex align-items-end">

                <a href="{{ route('laporan.pns.temuan.cetak') }}" target="_blank" class="btn btn-success w-100">

                    <i class="bi bi-printer"></i>
                    Cetak

                </a>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered" id="dataTable">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Nama PNS</th>

                            <th>Jabatan</th>

                            <th>Instansi</th>

                            <th>Jumlah Temuan</th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach ($pegawai as $item)
                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>
                                    {{ $item->nama }}
                                </td>


                                <td>
                                    {{ strtoupper($item->jenis_jabatan) }}
                                </td>


                                <td>
                                    {{ $item->auditee->nama_dinas ?? '-' }}
                                </td>


                                <td>

                                    {{ $item->lhps->sum(fn($lhp) => $lhp->temuans->count()) }}

                                </td>


                            </tr>
                        @endforeach


                    </tbody>


                </table>

            </div>

        </div>
    @endsection
