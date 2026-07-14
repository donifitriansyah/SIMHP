@extends('layouts.backend')

@section('content')
    <div class="card shadow-sm border-0">


        <div class="card-header bg-white">

            <h5 class="mb-0">
                Matriks Tindak Lanjut
            </h5>

        </div>



        <div class="card-body">


            <div class="table-responsive">


                <table class="table table-bordered table-sm">


                    <thead class="table-light">

                        <tr>

                            <th>No</th>
                            <th>LHP</th>
                            <th>Auditee</th>
                            <th>Temuan</th>
                            <th>Rekomendasi</th>
                            <th>Status</th>
                            <th>Pengembalian</th>
                            <th>Setor Pajak</th>
                            <th>Dokumen</th>

                        </tr>

                    </thead>



                    <tbody>


                        @foreach ($matriks as $item)
                            <tr>


                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    {{ $item['nomor_lhp'] }}

                                    <br>

                                    <small>
                                        {{ $item['tanggal'] }}
                                    </small>

                                </td>



                                <td>
                                    {{ $item['auditee'] }}
                                </td>



                                <td>
                                    {{ $item['temuan'] }}
                                </td>



                                <td>
                                    {{ $item['rekomendasi'] }}
                                </td>



                                <td>

                                    @if ($item['status'] == 'Selesai')
                                        <span class="badge bg-success">
                                            Selesai
                                        </span>
                                    @elseif($item['status'] == 'Dalam Proses')
                                        <span class="badge bg-warning">
                                            Dalam Proses
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Belum Ada
                                        </span>
                                    @endif


                                </td>



                                <td>
                                    Rp {{ number_format($item['pengembalian']) }}
                                </td>



                                <td>
                                    Rp {{ number_format($item['pajak']) }}
                                </td>



                                <td>

                                    @if ($item['dokumen'])
                                        Ada Dokumen
                                    @else
                                        -
                                    @endif

                                </td>



                            </tr>
                        @endforeach


                    </tbody>


                </table>


            </div>


        </div>


    </div>
@endsection
