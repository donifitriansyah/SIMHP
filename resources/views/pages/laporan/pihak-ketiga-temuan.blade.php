@extends('layouts.backend')


@section('content')


    <div class="container-fluid py-4">


        <div class="card border-0 shadow-sm">


            <div class="card-header bg-white">


                <h5 class="mb-0">

                    Daftar Pihak Ketiga Yang Memiliki Temuan

                </h5>




            </div>



            <div class="card-body">

                <form method="GET" action="{{ route('laporan.pihak.ketiga.temuan') }}" class="row g-3 mb-4">


                    <div class="col-md-3">

                        <label class="form-label">
                            Jenis Pemeriksaan
                        </label>

                        <select name="jenis" class="form-select" required>

                            <option value="">
                                -- Pilih Jenis --
                            </option>

                            <option value="internal" {{ request('jenis') == 'internal' ? 'selected' : '' }}>
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

                        <input type="date" name="tanggal_awal" class="form-control"
                            value="{{ request('tanggal_awal') }}">

                    </div>


                    <div class="col-md-2">

                        <label class="form-label">
                            Tanggal Akhir
                        </label>

                        <input type="date" name="tanggal_akhir" class="form-control"
                            value="{{ request('tanggal_akhir') }}">

                    </div>


                    <div class="col-md-2 d-flex align-items-end">

                        <button class="btn btn-primary w-100">

                            <i class="bi bi-search"></i>
                            Tampilkan

                        </button>

                    </div>


                    <div class="col-md-2 d-flex align-items-end">

                        <a href="{{ route('laporan.pihak.ketiga.temuan') }}" class="btn btn-secondary w-100">

                            Reset

                        </a>

                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('laporan.pihak.ketiga.temuan.cetak', request()->query()) }}" target="_blank"
                        class="btn btn-danger">

                        <i class="bi bi-file-earmark-pdf"></i>
                        Cetak PDF

                    </a>
                    </div>




                </form>

                <table class="table table-bordered table-striped" id="dataTable">


                    <thead>

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
                                Paket Pekerjaan
                            </th>

                            <th>
                                LHP
                            </th>

                            <th>
                                Tanggal LHP
                            </th>

                            <th>
                                Objek Pemeriksaan
                            </th>

                            <th>
                                Jumlah Temuan
                            </th>

                        </tr>

                    </thead>



                    <tbody>

                        @forelse($pihakKetiga as $item)
                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>
                                    {{ $item->nama_perusahaan }}
                                </td>


                                <td>
                                    {{ $item->nama_pimpinan }}
                                </td>


                                <td>
                                    {{ $item->paket_pekerjaan }}
                                </td>


                                <td>

                                    @foreach ($item->lhps as $lhp)
                                        @if ($lhp->temuans->count() > 0)
                                            <div class="mb-2">

                                                <a href="{{ route('lhp.show', $lhp->id) }}" class="text-primary fw-bold">

                                                    {{ $lhp->nomor_lhp }}

                                                </a>

                                            </div>

                                            @if (!$loop->last)
                                                <hr>
                                            @endif
                                        @endif
                                    @endforeach

                                </td>


                                <td>

                                    @foreach ($item->lhps as $lhp)
                                        @if ($lhp->temuans->count() > 0)
                                            <div class="mb-2">

                                                {{ \Carbon\Carbon::parse($lhp->tanggal_lhp)->format('d-m-Y') }}

                                            </div>


                                            @if (!$loop->last)
                                                <hr>
                                            @endif
                                        @endif
                                    @endforeach

                                </td>


                                <td>

                                    @foreach ($item->lhps as $lhp)
                                        @if ($lhp->temuans->count() > 0)
                                            <div class="mb-2">

                                                {{ $lhp->objek_pemeriksaan }}

                                            </div>


                                            @if (!$loop->last)
                                                <hr>
                                            @endif
                                        @endif
                                    @endforeach

                                </td>


                                <td class="text-center">

                                    {{ $item->lhps->sum(function ($lhp) {
                                        return $lhp->temuans->count();
                                    }) }}

                                </td>


                            </tr>


                        @empty
                        @endforelse

                    </tbody>


                </table>


            </div>


        </div>


    </div>


@endsection
