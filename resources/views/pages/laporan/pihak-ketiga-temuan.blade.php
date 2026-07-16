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

                <div class="col-md-2 mb-3 d-flex align-items-end">

                    <a href="{{ route('laporan.pihak.ketiga.temuan.cetak') }}" target="_blank" class="btn btn-success">

                        <i class="bi bi-printer"></i>
                        Cetak Laporan

                    </a>

                </div>
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
                                            {{ $lhp->objek_pemeriksaan }}


                                            @if (!$loop->last)
                                                <br>
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


                            <tr>

                                <td colspan="6" class="text-center">

                                    Belum ada pihak ketiga yang memiliki temuan

                                </td>

                            </tr>
                        @endforelse


                    </tbody>


                </table>


            </div>


        </div>


    </div>


@endsection
