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

                <table class="table table-bordered" id="dataTable">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Nama Penyedia</th>
                            <th>Nomor LHP</th>
                            <th>Objek Pemeriksaan</th>
                            <th>Jumlah Temuan</th>
                            <th>Total Nilai Temuan</th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach ($detail as $pihakKetigaId => $items)
                            @php
                                $penyedia = $items->first()->pihakKetiga;
                            @endphp
                            <tr>


                                <td>
                                    {{ $loop->iteration }}
                                </td>



                                <td>
                                    {{ strtoupper($penyedia->nama_perusahaan ?? '-' ) }}
                                </td>



                                <td>
                                    @foreach ($items->pluck('temuan.lhp')->unique('id') as $lhp)
                                        <li>
                                            <a href="{{ route('lhp.show', $lhp->id) }}" target="_blank">

                                                {{ $lhp->nomor_lhp }}

                                            </a>
                                        </li>
                                    @endforeach
                                </td>



                                <td>

                                    @foreach ($items as $item)
                                        {{ $item->temuan->lhp->objek_pemeriksaan }}

                                        @if (!$loop->last)
                                            <br>
                                        @endif
                                    @endforeach

                                </td>



                                <td class="text-center">

                                    {{ $items->count() }}

                                </td>



                                <td class="text-end">


                                    Rp {{ number_format($items->sum('nilai_temuan'), 0, ',', '.') }}


                                </td>


                            </tr>
                        @endforeach


                    </tbody>

                </table>


            </div>


        </div>


    </div>
@endsection
