@extends('layouts.backend')


@section('content')
    <div class="card shadow-sm">


        <div class="card-header">

            <h5>
                Rekap Perkembangan Tindak Lanjut
            </h5>

        </div>



        <div class="card-body">


            <div class="table-responsive">


                <table class="table table-bordered text-center">


                    <thead class="table-light">


                        <tr>

                            <th rowspan="2">
                                No
                            </th>

                            <th rowspan="2">
                                Wilayah Kerja
                            </th>

                            <th rowspan="2">
                                JML LHP
                            </th>


                            <th colspan="3">
                                JUMLAH
                            </th>


                            <th colspan="6">
                                PERKEMBANGAN TINDAK LANJUT
                            </th>


                        </tr>


                        <tr>

                            <th>T</th>
                            <th>R</th>
                            <th>S</th>

                            <th>D</th>
                            <th>B</th>


                        </tr>


                    </thead>



                    <tbody>


                        @foreach ($laporan as $item)
                            <tr>


                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>
                                    {{ $item['wilayah'] }}
                                </td>


                                <td>
                                    {{ $item['lhp'] }}
                                </td>


                                <td>
                                    {{ $item['temuan'] }}
                                </td>


                                <td>
                                    {{ $item['rekomendasi'] }}
                                </td>


                                <td>
                                    {{ $item['selesai'] }}
                                </td>


                                <td>
                                    {{ $item['proses'] }}
                                </td>


                                <td>
                                    {{ $item['belum'] }}
                                </td>



                            </tr>
                        @endforeach


                    </tbody>



                </table>


            </div>


        </div>


    </div>
@endsection
