@extends('layouts.backend')


@section('content')


    <div class="container-fluid py-4">


        <form method="GET" action="{{ route('laporan.irban') }}">


            <select name="irban_id" class="form-control">


                <option>
                    Pilih Irban
                </option>


                @foreach ($listIrban as $irban)
                    <option value="{{ $irban->id }}">

                        {{ $irban->nama_irban }}

                    </option>
                @endforeach


            </select>


            <button class="btn btn-primary mt-2">

                Tampilkan

            </button>


        </form>



        @if ($laporan)


            <h5 class="mt-4">

                {{ $laporan['wilayah'] }}

            </h5>



            <table class="table table-bordered">


                <thead>

                    <tr>

                        <th>No</th>

                        <th>Obrik</th>

                        <th>JML LHP</th>

                        <th>Temuan</th>

                        <th>Rekomendasi</th>

                        <th>S</th>

                        <th>D</th>

                        <th>B</th>

                        <th>Kerugian</th>

                        <th>Disetor</th>

                        <th>Sisa</th>

                    </tr>

                </thead>



                <tbody>


                    @if ($laporan['nihil'])
                        <tr>

                            <td colspan="11" class="text-center fw-bold">

                                NIHIL

                            </td>

                        </tr>
                    @else
                        @foreach ($laporan['lhp'] as $item)
                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>
                                    -
                                </td>


                                <td>
                                    1
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
                                    {{ $item['dalam_proses'] }}
                                </td>


                                <td>
                                    {{ $item['belum'] }}
                                </td>


                                <td>
                                    Rp {{ number_format($item['kerugian']) }}
                                </td>


                                <td>
                                    Rp {{ number_format($item['disetor']) }}
                                </td>


                                <td>
                                    Rp {{ number_format($item['sisa']) }}
                                </td>


                            </tr>
                        @endforeach
                    @endif


                </tbody>


            </table>


        @endif



    </div>


@endsection
