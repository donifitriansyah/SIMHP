<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top border-bottom">

    <div class="container-fluid px-4">

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">

            <img src="{{ asset('img/logo.png') }}"
                width="42"
                class="me-2">

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
        <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSIMHP">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse"
            id="navbarSIMHP">

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

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                        href="#"
                        data-bs-toggle="dropdown">

                        <i class="bi bi-database me-1"></i>

                        Master Data

                    </a>

                    <ul class="dropdown-menu shadow border-0">

                        <li>

                            <a class="dropdown-item"
                                href="#">

                                Profil Inspektorat

                            </a>

                        </li>

                        <li>

                            <a class="dropdown-item"
                                href="#">

                                Manajemen User

                            </a>

                        </li>

                        <li>

                            <a class="dropdown-item"
                                href="#">

                                Data Irban

                            </a>

                        </li>

                        <li>

                            <a class="dropdown-item"
                                href="#">

                                Data Auditee

                            </a>

                        </li>

                        <li>

                            <a class="dropdown-item"
                                href="#">

                                Pihak Ketiga

                            </a>

                        </li>

                    </ul>

                </li>

                <!-- Pemeriksaan -->

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                        href="#"
                        data-bs-toggle="dropdown">

                        <i class="bi bi-folder2-open me-1"></i>

                        Pemeriksaan

                    </a>

                    <ul class="dropdown-menu shadow border-0">

                        <li>

                            <a class="dropdown-item"
                                href="#">

                                Laporan Hasil Pemeriksaan

                            </a>

                        </li>

                        <li>

                            <a class="dropdown-item"
                                href="#">

                                Temuan Pemeriksaan

                            </a>

                        </li>

                        <li>

                            <a class="dropdown-item"
                                href="#">

                                Rekomendasi

                            </a>

                        </li>

                    </ul>

                </li>

                <!-- Tindak Lanjut -->

                <li class="nav-item">

                    <a class="nav-link"
                        href="#">

                        <i class="bi bi-check2-square me-1"></i>

                        Tindak Lanjut

                    </a>

                </li>

                <!-- Laporan -->

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                        href="#"
                        data-bs-toggle="dropdown">

                        <i class="bi bi-file-earmark-bar-graph me-1"></i>

                        Laporan

                    </a>

                    <ul class="dropdown-menu shadow border-0">

                        <li>

                            <a class="dropdown-item"
                                href="#">

                                Pemantauan Hasil Pemeriksaan

                            </a>

                        </li>

                        <li>

                            <a class="dropdown-item"
                                href="#">

                                Rekap Tindak Lanjut

                            </a>

                        </li>

                    </ul>

                </li>

            </ul>

            <!-- Right -->

            <ul class="navbar-nav">

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle d-flex align-items-center"
                        href="#"
                        data-bs-toggle="dropdown">

                        <div class="avatar-circle me-2">

                            {{ strtoupper(substr(auth()->user()->name,0,1)) }}

                        </div>

                        {{ auth()->user()->name }}

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">

                        <li>

                            <a class="dropdown-item"
                                href="#">

                                <i class="bi bi-person me-2"></i>

                                Profil

                            </a>

                        </li>

                        <li>

                            <hr class="dropdown-divider">

                        </li>

                        <li>

                            <form method="POST"
                                action="{{ route('logout') }}">

                                @csrf

                                <button
                                    class="dropdown-item text-danger">

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
