@extends('layouts.backend')


@section('content')
    <div class="container-fluid py-4">


        <div class="d-flex justify-content-between mb-4">

            <div>
                <h4 class="fw-bold">
                    LHP Lengkap
                </h4>

                <p class="text-muted">
                    Daftar laporan hasil pemeriksaan yang sudah lengkap
                </p>
            </div>


            <a href="{{ url()->previous() }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

        </div>



        <div class="card border-0 shadow-sm">


            <div class="card-header bg-primary text-white">

                <strong>
                    Data LHP Lengkap
                </strong>

            </div>



            <div class="card-body">


                <div class="table-responsive">


                    <table class="table table-bordered table-striped align-middle" id="dataTable">


                        <thead class="table-light">

                            <tr>

                                <th width="50">
                                    No
                                </th>

                                <th>
                                    Nomor LHP
                                </th>

                                <th>
                                    Tanggal LHP
                                </th>

                                <th>
                                    Irban
                                </th>

                                <th>
                                    Auditee
                                </th>

                                <th>
                                    Temuan
                                </th>

                                <th width="150">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                            @forelse($lhps as $lhp)
                                <tr>


                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>

                                        {{ $lhp->nomor_lhp }}

                                    </td>


                                    <td>

                                        {{ \Carbon\Carbon::parse($lhp->tanggal_lhp)->format('d-m-Y') }}

                                    </td>


                                    <td>

                                        {{ $lhp->irban->nama_irban ?? '-' }}

                                    </td>


                                    <td>

                                        {{ $lhp->auditee->nama_dinas ?? ($lhp->nama_pejabat_eksternal ?? '-') }}

                                    </td>


                                    <td class="text-center">

                                        <span class="badge bg-danger">

                                            {{ $lhp->temuans->count() }}

                                            Temuan

                                        </span>

                                    </td>


                                    <td>


                                        <a href="{{ route('lhp.show', $lhp->id) }}" class="btn btn-primary btn-sm">

                                            <i class="bi bi-eye"></i>

                                            Detail

                                        </a>


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
