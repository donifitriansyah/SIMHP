@extends('layouts.backend')


@section('content')
    <div class="container-fluid py-4">


        <div class="card border-0 shadow-sm">


            <div class="card-header bg-danger text-white">

                <h5 class="mb-0">
                    LHP Belum Lengkap
                </h5>

            </div>


            <div class="card-body">




                <div class="table-responsive">


                    <table class="table table-bordered table-striped align-middle" id="dataTable">


                        <thead class="table-danger">


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
                                    Objek Pemeriksaan
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

                                        {{ $lhp->objek_pemeriksaan }}

                                    </td>



                                    <td class="text-center">

                                        <span class="badge bg-warning">

                                            {{ $lhp->temuans->count() }}

                                        </span>

                                    </td>



                                    <td>


                                        <a href="{{ route('lhp.show', $lhp->id) }}" class="btn btn-info btn-sm text-white">


                                            <i class="bi bi-eye"></i>


                                        </a>



                                        @if (auth()->user()->isSuperUser())
                                            <a href="{{ route('lhp.edit', $lhp->id) }}" class="btn btn-warning btn-sm">


                                                <i class="bi bi-pencil"></i>


                                            </a>


                                            <form action="{{ route('lhp.destroy', $lhp->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Hapus LHP ini?')">


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


                                <tr>

                                    <td colspan="7" class="text-center text-muted">


                                        Belum ada LHP belum lengkap


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
