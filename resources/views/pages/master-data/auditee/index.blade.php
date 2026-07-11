@extends('layouts.backend')

@section('title', 'Data Auditee')


@section('content')

    <div class="container-fluid">


        <div class="card dashboard-card border-0 shadow-sm">


            <div class="card-header d-flex justify-content-between align-items-center">


                <h5 class="mb-0">

                    <i class="bi bi-building me-2"></i>

                    Data Auditee

                </h5>


                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">


                    <i class="bi bi-plus-circle me-1"></i>

                    Tambah Auditee


                </button>


            </div>



            <div class="card-body">


                <div class="table-responsive">


                    <table class="table table-hover align-middle" id="dataTable">


                        <thead class="table-primary">


                            <tr>

                                <th width="50">
                                    No
                                </th>


                                <th>
                                    Nama Dinas
                                </th>


                                <th>
                                    Alamat
                                </th>


                                <th>
                                    Pejabat
                                </th>


                                <th width="120">
                                    Aksi
                                </th>


                            </tr>


                        </thead>



                        <tbody>


                            @foreach ($auditees as $auditee)
                                <tr>


                                    <td>

                                        {{ $loop->iteration }}

                                    </td>



                                    <td>

                                        <strong>
                                            {{ $auditee->nama_dinas }}
                                        </strong>

                                    </td>



                                    <td>

                                        {{ $auditee->alamat }}

                                    </td>



                                    <td>


                                        @foreach ($auditee->pejabat as $p)
                                            <div class="mb-2">


                                                <span class="badge bg-primary">
                                                    @php
                                                        $jabatan = [
                                                            'pimpinan' => 'Pimpinan',
                                                            'ppk' => 'PPK',
                                                            'pptk' => 'PPTK',
                                                        ];
                                                    @endphp

                                                    {{ $jabatan[$p->jenis_jabatan] ?? ucfirst($p->jenis_jabatan) }}
                                                </span>


                                                <br>


                                                {{ $p->nama }}

                                                <small class="text-muted">

                                                    ({{ $p->tahun }})
                                                </small>


                                            </div>
                                        @endforeach


                                    </td>




                                    <td>


                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $auditee->id }}">


                                            <i class="bi bi-pencil"></i>


                                        </button>



                                        <form action="{{ route('auditee.destroy', $auditee->id) }}" method="POST"
                                            class="d-inline">


                                            @csrf

                                            @method('DELETE')


                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus data auditee?')">


                                                <i class="bi bi-trash"></i>


                                            </button>


                                        </form>


                                    </td>


                                </tr>
                            @endforeach


                        </tbody>


                    </table>


                </div>


            </div>


        </div>


    </div>



    @include('pages.master-data.auditee.modal-create')



    @foreach ($auditees as $auditee)
        @include('pages.master-data.auditee.modal-edit', [
            'auditee' => $auditee,
        ])
    @endforeach



@endsection
