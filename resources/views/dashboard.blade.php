@extends('layouts.backend')

@section('title','Dashboard')

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

    <!-- Statistik -->

    <div class="row g-4">

        <div class="col-lg-3 col-md-6">

            <div class="card dashboard-card border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Total LHP
                            </small>

                            <h2 class="fw-bold mt-2">
                                125
                            </h2>

                        </div>

                        <div class="dashboard-icon bg-primary">

                            <i class="bi bi-file-earmark-text"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card dashboard-card border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Temuan
                            </small>

                            <h2 class="fw-bold mt-2">
                                327
                            </h2>

                        </div>

                        <div class="dashboard-icon bg-warning">

                            <i class="bi bi-search"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card dashboard-card border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Rekomendasi
                            </small>

                            <h2 class="fw-bold mt-2">
                                412
                            </h2>

                        </div>

                        <div class="dashboard-icon bg-success">

                            <i class="bi bi-check2-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-3 col-md-6">

            <div class="card dashboard-card border-0">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Tindak Lanjut
                            </small>

                            <h2 class="fw-bold mt-2">
                                287
                            </h2>

                        </div>

                        <div class="dashboard-icon bg-danger">

                            <i class="bi bi-clock-history"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Grafik -->

    <div class="row mt-4">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <strong>
                        Grafik Hasil Pemeriksaan
                    </strong>

                </div>

                <div class="card-body">

                    <div style="height:350px;" class="d-flex align-items-center justify-content-center text-muted">

                        Grafik akan ditampilkan di sini

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <strong>

                        Aktivitas Terbaru

                    </strong>

                </div>

                <div class="card-body">

                    <ul class="list-group list-group-flush">

                        <li class="list-group-item">

                            LHP Nomor 02 telah ditambahkan.

                        </li>

                        <li class="list-group-item">

                            Temuan baru berhasil dibuat.

                        </li>

                        <li class="list-group-item">

                            Tindak lanjut divalidasi.

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
