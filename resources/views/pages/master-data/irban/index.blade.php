@extends('layouts.backend')

@section('title', 'Data Irban')

@section('content')

    <div class="card shadow-sm border-0">


        <div class="card-header bg-white d-flex justify-content-between align-items-center">


            <div>

                <h5 class="mb-1">

                    <i class="bi bi-person-badge me-2"></i>

                    Data Irban

                </h5>


                <small class="text-muted">

                    Data Inspektur Pembantu Wilayah

                </small>

            </div>


            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">


                <i class="bi bi-plus-circle me-1"></i>

                Tambah Irban


            </button>


        </div>



        <div class="card-body">


            <div class="table-responsive">


                <table id="dataTable" class="table table-hover align-middle">


                    <thead>


                        <tr>

                            <th width="50">
                                No
                            </th>

                            <th>
                                Kode Irban
                            </th>

                            <th>
                                Nama Irban
                            </th>

                            <th>
                                Nama Inspektur Pembantu
                            </th>


                            <th width="120">
                                Aksi
                            </th>


                        </tr>


                    </thead>



                    <tbody>


                        @forelse($irbans as $irban)
                            <tr>


                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <span class="badge bg-primary">

                                        {{ $irban->kode }}

                                    </span>

                                </td>


                                <td>

                                    {{ $irban->nama_irban }}

                                </td>


                                <td>

                                    {{ $irban->nama_inspektur_pembantu }}

                                </td>




                                <td>


                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $irban->id }}">

                                        <i class="bi bi-pencil-square"></i>

                                    </button>



                                    <form action="{{ route('irban.destroy', $irban->id) }}" method="POST" class="d-inline">


                                        @csrf
                                        @method('DELETE')


                                        <button type="submit" class="btn btn-danger btn-sm btn-delete">


                                            <i class="bi bi-trash"></i>


                                        </button>


                                    </form>


                                </td>


                            </tr>


                            @include('pages.master-data.irban.modal-edit')



                        @empty


                            
                        @endforelse


                    </tbody>



                </table>


            </div>


        </div>


    </div>



    @include('pages.master-data.irban.modal-create')



@endsection


