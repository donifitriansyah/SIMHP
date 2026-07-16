<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top border-bottom">

    <div class="container-fluid px-4">

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">

            <img src="{{ asset('img/logo.png') }}" width="42" class="me-2">

            <div>

                <div class="fw-bold text-primary">
                    SIMHP
                </div>

                <small class="text-muted">
                    Inspektorat
                </small>

            </div>

        </a>

        <!-- Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSIMHP">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarSIMHP">

            <!-- Menu -->
            <ul class="navbar-nav mx-auto">

                <li class="nav-item">

                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">

                        <i class="bi bi-speedometer2 me-1"></i>

                        Dashboard

                    </a>

                </li>

                <!-- Master -->
                @auth
                    @if (auth()->user()->role == 'super_user')
                        <li class="nav-item dropdown">

                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-database me-1"></i>
                                Master Data
                            </a>

                            <ul class="dropdown-menu shadow border-0">

                                <li>
                                    <a class="dropdown-item" href="{{ route('profil-inspektorat.index') }}">
                                        Profil Inspektorat
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('users.index') }}">
                                        Manajemen User
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('irban.index') }}">
                                        Data Irban
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('auditee.index') }}">
                                        Data Auditee
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('pihak-ketiga.index') }}">
                                        Pihak Ketiga
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('pegawai.index') }}">
                                        Data Pegawai
                                    </a>
                                </li>

                            </ul>

                        </li>
                    @endif
                @endauth

                <!-- Pemeriksaan -->

                <li class="nav-item">

                    <a class="nav-link" href="{{ route('lhp.index') }}">


                        <i class="bi bi-folder2-open me-1"></i>

                        Laporan Hasil Pemeriksaan


                    </a>



                    {{-- <ul class="dropdown-menu shadow border-0">


                        <li>

                            <a class="dropdown-item d-flex justify-content-between align-items-center"
                                href="{{ route('lhp.index') }}">


                                <span>
                                    Semua Data
                                </span>


                                <span class="badge bg-primary rounded-pill">
                                    {{ $jumlahLhp['semua'] ?? 0 }}
                                </span>


                            </a>

                        </li>




                        <li>

                            <a class="dropdown-item d-flex justify-content-between align-items-center"
                                href="{{ route('lhp.filter', 'nihil') }}">


                                <span>
                                    Nihil
                                </span>


                                <span class="badge bg-info rounded-pill">
                                    {{ $jumlahLhp['nihil'] ?? 0 }}
                                </span>


                            </a>

                        </li>




                        <li>

                            <a class="dropdown-item d-flex justify-content-between align-items-center"
                                href="{{ route('lhp.filter', 'belum_proses') }}">


                                <span>
                                    Belum Proses
                                </span>


                                <span class="badge bg-secondary rounded-pill">
                                    {{ $jumlahLhp['belum_proses'] ?? 0 }}
                                </span>


                            </a>

                        </li>





                        <li>

                            <a class="dropdown-item d-flex justify-content-between align-items-center"
                                href="{{ route('lhp.filter', 'dalam_proses') }}">


                                <span>
                                    Dalam Proses
                                </span>


                                <span class="badge bg-warning rounded-pill">
                                    {{ $jumlahLhp['dalam_proses'] ?? 0 }}
                                </span>


                            </a>

                        </li>





                        <li>

                            <a class="dropdown-item d-flex justify-content-between align-items-center"
                                href="{{ route('lhp.filter', 'selesai') }}">


                                <span>
                                    Selesai
                                </span>


                                <span class="badge bg-success rounded-pill">
                                    {{ $jumlahLhp['selesai'] ?? 0 }}
                                </span>


                            </a>

                        </li>


                    </ul> --}}


                </li>

                <!-- Tindak Lanjut -->



                <!-- Laporan -->

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">

                        <i class="bi bi-file-earmark-bar-graph me-1"></i>

                        Laporan

                    </a>

                    <ul class="dropdown-menu shadow border-0">

                        <li>

                            <a class="dropdown-item" href="{{ route('laporan.index') }}">

                                Pemantauan Hasil Pemeriksaan

                            </a>

                        </li>
                        <li>

                            <a class="dropdown-item" href="{{ route('laporan.irban') }}">

                                Laporan Per Irban

                            </a>

                        </li>
                        <li>

                            <a class="dropdown-item" href="{{ route('matriks.index') }}">

                                Matriks Tindak Lanjut

                            </a>

                        </li>
                        <li>

                            <a class="dropdown-item" href="{{ route('laporan.pns.temuan') }}">

                                Temuan (PNS)

                            </a>

                        </li>

                        <li>

                            <a class="dropdown-item" href="{{ route('laporan.pihak.ketiga.temuan') }}">

                                Temuan (Pihak Ketiga)

                            </a>

                        </li>

                        {{-- <li>

                            <a class="dropdown-item" href="#">

                                Rekap Tindak Lanjut

                            </a>

                        </li> --}}

                    </ul>

                </li>

            </ul>

            <!-- Right -->

            <ul class="navbar-nav">

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                        data-bs-toggle="dropdown">

                        <div class="avatar-circle me-2">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                        {{ auth()->user()->name }}

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">


                        <li>

                            <hr class="dropdown-divider">

                        </li>

                        <li>

                            <form method="POST" action="{{ route('logout') }}">

                                @csrf

                                <button class="dropdown-item text-danger">

                                    <i class="bi bi-box-arrow-right me-2"></i>

                                    Logout

                                </button>

                            </form>

                        </li>

                    </ul>

                </li>

            </ul>

        </div>

    </div>

</nav>
