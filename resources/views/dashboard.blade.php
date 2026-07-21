@extends('layouts.backend')

@section('title', 'Dashboard')

@section('content')

    <div class="py-4">

        <div class="mb-4">

            <h3 class="fw-bold text-dark">
                Dashboard
            </h3>

            <p class="text-muted mb-0">
                Selamat datang kembali,
                <strong>{{ auth()->user()->name }}</strong>
            </p>

        </div>
        <div class="mb-4">

            <a href="{{ route('dashboard', ['jenis' => 'internal']) }}"
                class="btn {{ $jenis == 'internal' ? 'btn-primary' : 'btn-outline-primary' }}">
                Internal
            </a>


            <a href="{{ route('dashboard', ['jenis' => 'eksternal']) }}"
                class="btn {{ $jenis == 'eksternal' ? 'btn-primary' : 'btn-outline-primary' }}">
                Eksternal
            </a>

        </div>
        <!-- Statistik -->

        <div class="row g-4">

            <div class="col-lg-3 col-md-6">
                <a href="{{ route($jenis == 'internal' ? 'pemeriksaan.internal' : 'pemeriksaan.eksternal') }}"
                    class="text-decoration-none text-dark">
                    <div class="card dashboard-card border-0">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <small class="text-muted">
                                        Total LHP
                                    </small>

                                    <h2 class="fw-bold mt-2">
                                        {{ $totalLhp }}
                                    </h2>

                                </div>

                                <div class="dashboard-icon bg-primary">

                                    <i class="bi bi-file-earmark-text"></i>

                                </div>

                            </div>

                        </div>

                    </div>
                </a>

            </div>
            <div class="col-lg-3 col-md-6">
                <a href="{{ route('temuan.index', ['jenis' => $jenis]) }}" class="text-decoration-none text-dark">

                    <div class="card dashboard-card border-0">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <small class="text-muted">
                                        Temuan
                                    </small>

                                    <h2 class="fw-bold mt-2">

                                        {{ $totalTemuan }}

                                    </h2>

                                </div>

                                <div class="dashboard-icon bg-warning">

                                    <i class="bi bi-search"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('rekomendasi.index', ['jenis' => $jenis]) }}" class="text-decoration-none text-dark">

                    <div class="card dashboard-card border-0">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <small class="text-muted">
                                        Rekomendasi
                                    </small>

                                    <h2 class="fw-bold mt-2">

                                        {{ $totalRekomendasi }}

                                    </h2>

                                </div>

                                <div class="dashboard-icon bg-success">

                                    <i class="bi bi-check2-circle"></i>

                                </div>

                            </div>

                        </div>

                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('tindak-lanjut.index', ['jenis' => $jenis]) }}" class="text-decoration-none text-dark">

                    <div class="card dashboard-card border-0">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <small class="text-muted">
                                        Tindak Lanjut
                                    </small>

                                    <h2 class="fw-bold mt-2">

                                        {{ $totalTindakLanjut }}

                                    </h2>

                                </div>

                                <div class="dashboard-icon bg-danger">

                                    <i class="bi bi-clock-history"></i>

                                </div>

                            </div>

                        </div>

                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('lhp.lengkap', ['jenis' => $jenis]) }}" class="text-decoration-none text-dark">

                    <div class="card dashboard-card border-0">

                        <div class="card-body">

                            <small class="text-muted">
                                LHP Lengkap
                            </small>


                            <h2 class="fw-bold text-success mt-2">

                                {{ $lhpLengkap }}

                            </h2>


                        </div>

                    </div>
                </a>

            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('lhp.belum-lengkap',['jenis'=>$jenis]) }}"
class="text-decoration-none text-dark">
                <div class="card dashboard-card border-0">

                    <div class="card-body">

                        <small class="text-muted">
                            Belum Lengkap
                        </small>


                        <h2 class="fw-bold text-danger mt-2">

                            {{ $lhpTidakLengkap }}

                        </h2>


                    </div>

                </div>
            </a>

            </div>

            <!-- Total Kerugian -->

            <div class="col-lg-3 col-md-6">

                <div class="card dashboard-card border-0">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <small class="text-muted">
                                    Total Kerugian
                                </small>


                                <h4 class="fw-bold mt-2 text-danger">

                                    Rp
                                    {{ number_format($totalKerugian, 0, ',', '.') }}

                                </h4>


                            </div>


                            <div class="dashboard-icon bg-danger">

                                <i class="bi bi-cash-stack"></i>

                            </div>


                        </div>


                    </div>


                </div>


            </div>



            <!-- Sudah Dikembalikan -->


            <div class="col-lg-3 col-md-6">


                <div class="card dashboard-card border-0">


                    <div class="card-body">


                        <div class="d-flex justify-content-between">


                            <div>


                                <small class="text-muted">

                                    Sudah Dikembalikan

                                </small>


                                <h4 class="fw-bold mt-2 text-success">


                                    Rp
                                    {{ number_format($totalPengembalian, 0, ',', '.') }}


                                </h4>


                            </div>



                            <div class="dashboard-icon bg-success">


                                <i class="bi bi-arrow-down-circle"></i>


                            </div>


                        </div>


                    </div>


                </div>


            </div>

        </div>

        <!-- Grafik -->

        <div class="row mt-4">

            @if (auth()->user()->role == 'super_user')

                {{-- Status LHP --}}
                <div class="col-lg-4 mb-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-white">
                            <strong>Status LHP</strong>
                        </div>

                        <div class="card-body">
                            <canvas id="statusLhpChart" height="180" class="status-chart"></canvas>
                        </div>

                    </div>

                </div>
                <div class="col-lg-8 mb-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-white">
                            <strong>Aktivitas Pengguna</strong>
                        </div>

                        <div class="card-body p-0">

                            <div style="max-height: 400px; overflow-y: auto;">

                                <ul class="list-group list-group-flush">

                                    @forelse($aktivitas as $item)
                                        <li class="list-group-item">

                                            <div class="d-flex">

                                                <div class="me-3">
                                                    <i class="bi bi-clock-history fs-4 text-primary"></i>
                                                </div>

                                                <div>
                                                    <strong>{{ $item->user->name }}</strong>

                                                    <div>
                                                        {{ $item->deskripsi }}
                                                    </div>

                                                    <small class="text-muted">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </small>
                                                </div>

                                            </div>

                                        </li>

                                    @empty

                                        <li class="list-group-item text-center text-muted">
                                            Belum ada aktivitas.
                                        </li>
                                    @endforelse

                                </ul>

                            </div>

                        </div>

                    </div>

                </div>
            @else
                {{-- Status --}}
                <div class="col-lg-6 mb-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-white">
                            <strong>Status LHP</strong>
                        </div>

                        <div class="card-body">
                            <canvas id="statusLhpChart" height="180" class="status-chart"></canvas>
                        </div>

                    </div>

                </div>

                {{-- Temuan Irban --}}
                <div class="col-lg-6 mb-4">

                    <div class="card border-0 shadow-sm h-100">

                        <div class="card-header bg-white">
                            <strong>Jumlah Temuan Berdasarkan Irban</strong>
                        </div>

                        <div class="card-body">
                            <canvas id="temuanIrbanChart"></canvas>
                        </div>

                    </div>

                </div>

            @endif

        </div>





        {{-- Grafik Temuan Irban --}}

        @if (auth()->user()->role == 'super_user')
            <div class="row">

                <div class="col-lg-12 mb-4">

                    <div class="card border-0 shadow-sm">

                        <div class="card-header bg-white">
                            <strong>Jumlah Temuan Berdasarkan Irban</strong>
                        </div>

                        <div class="card-body">
                            <canvas id="temuanIrbanChart" height="100"></canvas>
                        </div>

                    </div>

                </div>

            </div>
        @endif

        <div class="row">


            <div class="col-lg-12 mb-4">


                <div class="card border-0 shadow-sm">


                    <div class="card-header bg-white">

                        <strong>
                            Kerugian Negara / Daerah
                        </strong>

                    </div>


                    <div class="card-body">

                        <canvas id="kerugianChart" height="100"></canvas>

                    </div>


                </div>


            </div>


        </div>
        <style>
            .status-chart {
                max-width: 500px;
                max-height: 500px;
                margin: 0 auto;
            }
        </style>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        const statusCtx = document.getElementById('statusLhpChart');


        new Chart(statusCtx, {

            type: 'pie',

            data: {

                labels: [
                    'Selesai',
                    'Dalam Proses',
                    'Belum Diproses',
                    'Nihil'
                ],

                datasets: [{

                    data: [

                        {{ $statusLhp['selesai'] }},
                        {{ $statusLhp['dalam_proses'] }},
                        {{ $statusLhp['belum_proses'] }},
                        {{ $statusLhp['nihil'] }}

                    ]

                }]

            },


            options: {

                responsive: true,

                plugins: {

                    legend: {

                        position: 'bottom'

                    }

                }

            }


        });

        const temuanIrban = @json($temuanIrban);


        new Chart(
            document.getElementById('temuanIrbanChart'), {

                type: 'bar',

                data: {

                    labels: temuanIrban.map(item => item.nama),

                    datasets: [{

                        label: 'Jumlah Temuan',

                        data: temuanIrban.map(item => item.total)

                    }]

                },

                options: {

                    responsive: true,

                    scales: {

                        y: {
                            beginAtZero: true
                        }

                    }

                }

            }
        );

        const kerugianCtx = document.getElementById('kerugianChart');


        new Chart(kerugianCtx, {


            type: 'bar',


            data: {


                labels: [

                    'Total Kerugian',

                    'Sudah Dikembalikan',

                    'Sisa Kerugian'

                ],



                datasets: [{


                    label: 'Nilai Rupiah',


                    data: [


                        {{ $dataKerugian['total'] }},


                        {{ $dataKerugian['dikembalikan'] }},


                        {{ $dataKerugian['sisa'] }}



                    ],


                    borderWidth: 1


                }]


            },


            options: {


                indexAxis: 'y',


                responsive: true,


                plugins: {


                    legend: {


                        display: false


                    },


                    tooltip: {


                        callbacks: {


                            label: function(context) {


                                return 'Rp ' +

                                    new Intl.NumberFormat('id-ID')

                                    .format(context.raw);



                            }


                        }


                    }


                },


                scales: {


                    x: {


                        ticks: {


                            callback: function(value) {


                                return 'Rp ' +

                                    new Intl.NumberFormat('id-ID')

                                    .format(value);


                            }


                        }


                    }


                }


            }



        });
    </script>




@endsection
