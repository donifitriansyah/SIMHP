@extends('layouts.backend')

@section('content')


    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">
                    <i class="bi bi-briefcase-fill me-2"></i>
                    Data Laporan Hasil Pemeriksaan (LHP)
                </h5>

                <small class="text-muted mb-0">
                    Kelola data laporan hasil pemeriksaan
                </small>

            </div>

            <a href="{{ route('lhp.create') }}" class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>
                Tambah LHP

            </a>

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
                                Nomor LHP
                            </th>


                            <th>
                                Auditee
                            </th>


                            <th>
                                Objek Pemeriksaan
                            </th>


                            <th>
                                Jenis Pemeriksaan
                            </th>


                            <th>
                                Tanggal LHP
                            </th>


                            <th>
                                Status
                            </th>


                            <th width="15%">
                                Aksi
                            </th>


                        </tr>

                    </thead>



                    <tbody>


                        @forelse($lhps as $l)
                            <tr>


                                <td>
                                    {{ $loop->iteration }}
                                </td>



                                <td>

                                    <span class="fw-semibold">

                                        {{ $l->nomor_lhp }}

                                    </span>

                                </td>



                                <td>

                                    {{ $l->auditee->nama_dinas ?? '-' }}

                                </td>



                                <td>

                                    {{ $l->objekPemeriksaan->nama_objek ?? '-' }}

                                </td>



                                <td>

                                    <span class="badge bg-info">

                                        {{ strtoupper($l->jenis_pemeriksaan) }}

                                    </span>

                                </td>



                                <td>

                                    {{ \Carbon\Carbon::parse($l->tanggal_lhp)->format('d-m-Y') }}

                                </td>



                                <td>


                                    @if ($l->status_lhp == 'Lengkap')
                                        <span class="badge bg-success">
                                            Lengkap
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            Tidak Lengkap
                                        </span>
                                    @endif


                                </td>




                                <td>


                                    <div class="d-flex gap-2">


                                        {{-- Detail --}}

                                        <a href="{{ route('lhp.show', $l->id) }}" class="btn btn-sm btn-info">

                                            <i class="bi bi-eye"></i>

                                        </a>




                                        {{-- Edit --}}

                                        <a href="{{ route('lhp.edit', $l->id) }}" class="btn btn-sm btn-warning">

                                            <i class="bi bi-pencil"></i>

                                        </a>





                                        {{-- Delete --}}

                                        <form action="{{ route('lhp.destroy', $l->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus data LHP ini?')">


                                            @csrf
                                            @method('DELETE')


                                            <button class="btn btn-sm btn-danger">

                                                <i class="bi bi-trash"></i>

                                            </button>


                                        </form>



                                    </div>


                                </td>



                            </tr>



                        @empty


                            <tr>

                                <td colspan="8" class="text-center text-muted py-4">

                                    Belum ada data LHP

                                </td>

                            </tr>
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
@endsection
