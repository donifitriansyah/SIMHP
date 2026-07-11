<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIMHP')</title>

    <meta name="description" content="Sistem Informasi Monitoring Hasil Pengawasan">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')

</head>

<body>

    <div class="auth-wrapper">

        <!-- Background -->
        <div class="auth-background"></div>

        <!-- Overlay -->
        <div class="auth-overlay"></div>

        <!-- Content -->
        <div class="container-fluid px-0">

            <div class="row g-0 min-vh-100">

                <!-- LEFT -->
                <div class="col-lg-7 d-none d-lg-flex">

                    <div class="auth-left">

                        <div class="auth-brand">

                            <img src="{{ asset('img/logo1.png') }}"
                                class="brand-logo"
                                alt="Logo">

                            <div>

                                <h5>SIMHP</h5>

                                <span>
                                    Sistem Informasi Monitoring
                                    Hasil Pengawasan
                                </span>

                            </div>

                        </div>

                        <div class="auth-caption">

                            <h1>
                                Sistem Informasi
                                <br>
                                Monitoring
                                <br>
                                Hasil Pengawasan
                            </h1>

                            <p>

                                Mendukung pengelolaan data pemeriksaan,
                                temuan, rekomendasi, serta monitoring
                                tindak lanjut hasil pengawasan secara
                                terintegrasi.

                            </p>

                        </div>

                        <div class="auth-footer-left">

                            © {{ date('Y') }}
                            Inspektorat Kabupaten Ketapang

                        </div>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="col-lg-5 col-12">

                    <div class="auth-right">

                        @yield('content')

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/auth.js') }}"></script>

    @stack('scripts')

</body>

</html>
