@extends('layouts.backend')

@section('content')

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">
                    <i class="bi bi-briefcase-fill me-2"></i>
                    Data Pihak Ketiga
                </h5>

                <small class="text-muted mb-0">
                    Kelola data pihak ketiga dalam pemeriksaan
                </small>

            </div>

            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreate">

                <i class="bi bi-plus-circle me-1"></i>

                Tambah Pihak Ketiga

            </button>

        </div>

        <div class="card-body">



            <div class="table-responsive">


                <table class="table table-hover align-middle" id="dataTable">


                    <thead class="table-light">

                        <tr>

                            <th width="5%">
                                No
                            </th>

                            <th>
                                Nama Perusahaan
                            </th>

                            <th>
                                Nama Pimpinan
                            </th>

                            <th>
                                Alamat
                            </th>

                            <th>
                                Paket Pekerjaan
                            </th>

                            <th width="15%">
                                Aksi
                            </th>

                        </tr>

                    </thead>



                    <tbody>


                        @forelse($pihakKetigas as $p)
                            <tr>


                                <td>
                                    {{ $loop->iteration }}
                                </td>



                                <td>

                                    <span class="fw-semibold">

                                        {{ $p->nama_perusahaan }}

                                    </span>

                                </td>



                                <td>

                                    {{ $p->nama_pimpinan ?? '-' }}

                                </td>



                                <td>

                                    {{ $p->alamat ?? '-' }}

                                </td>



                                <td>

                                    {{ $p->paket_pekerjaan ?? '-' }}

                                </td>



                                <td>


                                    <div class="d-flex gap-2">


                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $p->id }}">


                                            <i class="bi bi-pencil"></i>


                                        </button>





                                        <form action="{{ route('pihak-ketiga.destroy', $p->id) }}" method="POST" class="d-inline">


                                            @csrf
                                            @method('DELETE')


                                            <button type="submit" class="btn btn-sm btn-danger btn-delete">


                                                <i class="bi bi-trash"></i>


                                            </button>


                                        </form>


                                    </div>


                                </td>



                            </tr>

                            @include('pages.master-data.pihak-ketiga.modal-edit')

                        @empty


                            
                        @endforelse



                    </tbody>


                </table>


            </div>

        </div>

        @if ($errors->any())
            <div class="alert alert-danger">

                <strong>Terjadi kesalahan:</strong>

                <ul class="mb-0 mt-2">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>
        @endif

    </div>



    @include('pages.master-data.pihak-ketiga.modal-create')

@endsection
