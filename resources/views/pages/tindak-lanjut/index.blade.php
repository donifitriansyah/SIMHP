@extends('layouts.backend')

@section('content')

    <div class="container-fluid py-4">


        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold">
                    Data Tindak Lanjut
                </h4>

                <p class="text-muted">
                    Monitoring tindak lanjut hasil pemeriksaan
                </p>
            </div>


            <a href="{{ route('dashboard', ['jenis' => $jenis]) }}" class="btn btn-secondary">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

        </div>



        {{-- Filter --}}
        @if (!auth()->user()->isUserView())
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">


                <form method="GET">


                    <input type="hidden" name="jenis" value="{{ $jenis }}">


                    <div class="row">



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



                        <div class="col-md-2 d-flex align-items-end">

                            <button class="btn btn-primary w-100">

                                <i class="bi bi-search"></i>
                                Filter

                            </button>

                        </div>



                        <div class="col-md-2 d-flex align-items-end">

                            <a href="{{ route('tindak-lanjut.index', ['jenis' => $jenis]) }}" class="btn btn-secondary w-100">

                                Reset

                            </a>

                        </div>


                    </div>



                </form>


            </div>

        </div>
        @endif





        <div class="card border-0 shadow-sm">

            <div class="card-body">


                <div class="table-responsive">


                    <table id="dataTable" class="table table-bordered table-striped">


                        <thead class="table-success text-center">

                            <tr>

                                <th>No</th>

                                <th>Nomor LHP</th>

                                <th>Irban</th>

                                <th>Auditee</th>

                                <th>Status</th>

                                <th>Pengembalian</th>

                                <th>Setor Pajak</th>

                                <th>Aksi</th>


                            </tr>

                        </thead>



                        <tbody>


                            @foreach ($tindakLanjuts as $tl)
                                <tr>


                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>
                                        {{ $tl->rekomendasi->temuan->lhp->nomor_lhp }}
                                    </td>



                                    <td>

                                        {{ $tl->rekomendasi->temuan->lhp->irban->nama_irban ?? '-' }}

                                    </td>



                                    <td>

                                        {{ $tl->rekomendasi->temuan->lhp->auditee->nama_dinas ?? '-' }}

                                    </td>



                                    <td class="text-center">

                                        <span class="badge bg-success">

                                            {{ $tl->status->nama_status ?? '-' }}

                                        </span>


                                    </td>



                                    <td class="text-end">

                                        Rp {{ number_format($tl->nilai_pengembalian ?? 0, 0, ',', '.') }}

                                    </td>



                                    <td class="text-end">

                                        Rp {{ number_format($tl->nilai_setor_pajak ?? 0, 0, ',', '.') }}

                                    </td>



                                    <td class="text-center">


                                        <a href="{{ route('lhp.show', $tl->rekomendasi->temuan->lhp_id) }}"
                                            class="btn btn-primary btn-sm">

                                            <i class="bi bi-eye"></i>

                                        </a>



                                        @if (auth()->user()->canEditTindakLanjut($tl->rekomendasi->temuan->lhp))
                                            <a href="{{ route('tindak-lanjut.edit', $tl->id) }}"
                                                class="btn btn-warning btn-sm">

                                                <i class="bi bi-pencil"></i>

                                            </a>
                                        @endif



                                        @if (auth()->user()->isSuperUser())
                                            <form action="{{ route('tindak-lanjut.destroy', $tl->id) }}" method="POST"
                                                class="d-inline">


                                                @csrf
                                                @method('DELETE')


                                                <button class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Hapus tindak lanjut?')">


                                                    <i class="bi bi-trash"></i>


                                                </button>


                                            </form>
                                        @endif


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
