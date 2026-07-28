@extends('layouts.backend')

@section('content')
    <div class="container-fluid">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-primary text-white">

                <h5 class="mb-0">
                    Register No LHP
                </h5>

            </div>


            <div class="card-body">


                {{-- Filter --}}
                {{-- Filter --}}
                <form method="GET" action="{{ route('register.lhp.index') }}">

                    <div class="row mb-3">


                        {{-- Jenis --}}
                        <div class="col-md-3">

                            <label class="form-label">
                                Jenis Pemeriksaan
                            </label>

                            <select name="jenis" class="form-select">
                                <option value="internal" {{ $jenis == 'internal' ? 'selected' : '' }}>
                                    Internal
                                </option>

                                <option value="eksternal" {{ $jenis == 'eksternal' ? 'selected' : '' }}>
                                    Eksternal
                                </option>
                            </select>

                        </div>



                        @if (!auth()->user()->isUserView())
                            <div class="col-md-3">

                                <label class="form-label">
                                    Tim Pemeriksa
                                </label>

                                <select name="irban_id" class="form-select">

                                    <option value="">
                                        Semua Tim Pemeriksa
                                    </option>

                                    @foreach ($irbans as $irban)
                                        <option value="{{ $irban->id }}"
                                            {{ request('irban_id') == $irban->id ? 'selected' : '' }}>

                                            {{ $irban->nama_irban }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>
                        @endif



                        {{-- Tanggal Awal --}}
                        <div class="col-md-3">

                            <label class="form-label">
                                Tanggal Awal
                            </label>


                            <input type="date" name="tanggal_awal" class="form-control"
                                value="{{ request('tanggal_awal') }}">


                        </div>



                        {{-- Tanggal Akhir --}}
                        <div class="col-md-3">

                            <label class="form-label">
                                Tanggal Akhir
                            </label>


                            <input type="date" name="tanggal_akhir" class="form-control"
                                value="{{ request('tanggal_akhir') }}">


                        </div>



                    </div>



                    <div class="row mb-3">


                        <div class="col-md-12">


                            <button class="btn btn-primary">

                                <i class="bi bi-search"></i>
                                Filter

                            </button>



                            <a href="{{ route('register.lhp.index') }}" class="btn btn-secondary">

                                Reset

                            </a>



                            {{-- <a href="{{ route('register.lhp.cetak', request()->query()) }}" target="_blank"
                                class="btn btn-danger float-end">

                                <i class="bi bi-printer"></i>
                                Cetak

                            </a> --}}


                        </div>


                    </div>


                </form>



                <div class="table-responsive">


                    <table class="table table-bordered table-striped align-middle" id="dataTable" style="font-size: 11px">


                        <thead class="table-light text-center">

                            <tr>

                                <th width="50">
                                    No
                                </th>

                                <th>
                                    No LHP
                                </th>

                                <th>
                                    Tim Pemeriksa
                                </th>

                                <th>
                                    No SPT
                                </th>

                                <th>
                                    Tgl SPT
                                </th>

                                <th>
                                    Tahun Pemeriksaan
                                </th>

                                <th>
                                    Dana Diawasi
                                </th>

                                <th>
                                    Dana Diperiksa
                                </th>

                                <th>
                                    Nama Pimpinan
                                </th>

                                <th>
                                    Objek Pemeriksaan
                                </th>

                                <th>
                                    Jenis Pemeriksaan
                                </th>


                            </tr>


                        </thead>



                        <tbody>


                            @foreach ($lhps as $lhp)
                                @php

                                    $totalTemuan = $lhp->temuans
                                        ->flatMap(function ($temuan) {
                                            return $temuan->detailFinansial;
                                        })
                                        ->sum('nilai_temuan');

                                @endphp


                                <tr>


                                    <td class="text-center">

                                        {{ $loop->iteration }}

                                    </td>



                                    <td>

                                        <a href="{{ route('lhp.show', $lhp->id) }}" target="_blank">

                                            {{ $lhp->nomor_lhp }}

                                        </a>

                                    </td>



                                    <td>

                                        {{ $lhp->irban->nama_irban ?? '-' }}

                                    </td>



                                    <td>

                                        {{ $lhp->nomor_spt }}

                                    </td>



                                    <td class="text-center">

                                        {{ \Carbon\Carbon::parse($lhp->tanggal_spt)->format('d-m-Y') }}

                                    </td>



                                    <td class="text-center">

                                        {{ \Carbon\Carbon::parse($lhp->tanggal_spt)->format('Y') }}

                                    </td>



                                    <td class="text-end">

                                        Rp
                                        {{ number_format($totalTemuan, 0, ',', '.') }}

                                    </td>




                                    <td class="text-end">

                                        Rp
                                        {{ number_format($lhp->jumlah_dana_diawasi, 0, ',', '.') }}

                                    </td>



                                    <td>

                                        {{ $lhp->irban->nama_penandatangan ?? '-' }}

                                    </td>



                                    <td>



                                        {{ $lhp->objek_pemeriksaan }}



                                    </td>



                                    <td>

                                        {{ $lhp->jenis_pemeriksaan }}

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
