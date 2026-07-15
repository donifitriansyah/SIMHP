<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'SIMHP')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.min.css">

    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    @stack('styles')

</head>

<body>

    @include('partials.navbar')

    <main class="main-content">

        <div class="container-fluid">

            @yield('content')

        </div>

    </main>

    @include('partials.footer')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.min.js"></script>
    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {

            button.addEventListener('click', function(e) {

                e.preventDefault();

                let form = this.closest('form');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data yang dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {

                    if (result.isConfirmed) {
                        form.submit();
                    }

                });

            });

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {


            $('#dataTable').DataTable({

                responsive: true,

                pageLength: 10,

                language: {

                    search: "Cari:",

                    lengthMenu: "Tampilkan _MENU_ data",

                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",

                    paginate: {

                        first: "Awal",

                        last: "Akhir",

                        next: "›",

                        previous: "‹"

                    },

                    emptyTable: "Belum ada data"

                }

            });


        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0d6efd',
                timer: 2500,
                timerProgressBar: true
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#dc3545'
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#dc3545'
            });
        </script>
    @endif

</body>

</html>
