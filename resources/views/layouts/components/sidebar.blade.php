{{-- components/sidebar.blade.php --}}
<aside class="main-sidebar bg-gradient-green elevation-4">

    {{-- Brand Logo --}}
    <a href="{{ url('/') }}" class="brand-link text-decoration-none">
        <img src="{{ asset('assets/logo_sdi.PNG') }}" alt="logo_sdi" class="brand-image img-circle elevation-3"
            style="opacity: 0.8">
        <span class="brand-text font-weight-light">LMS SDI</span>
        <small class="brand-subtitle font-light">Tompokersan</small>
    </a>

    {{-- Sidebar --}}
    <div class="sidebar">
        {{-- Sidebar user panel --}}
        <div class="user-panel mt-3 pb-3 mb-3 d-flex border-bottom">
            <div class="image">
                <img src="{{ Auth::user()->avatar ?? asset('lte/dist/img/user2-160x160.jpg') }}"
                    class="img-circle elevation-2" alt="User Image"
                    onerror="this.src='{{ asset('lte/dist/img/user2-160x160.jpg') }}'">
            </div>
            <div class="info">
                <a href="#" class="d-block text-white text-decoration-none">
                    {{ Auth::user()->name ?? 'Guest' }}
                </a>
                <small class="text-muted">
                    {{ ucfirst(Auth::user()->role ?? 'guest') }}
                </small>
            </div>
        </div>

        {{-- Sidebar Menu --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @php
                    $user = Auth::user();
                    $role = $user->role ?? '';
                    $currentRoute = Route::currentRouteName();

                    // Dashboard URL berdasarkan role
                    $dashboardUrl = '/';
                    $dashboardRoute = 'home';

                    switch ($role) {
                        case 'admin':
                            $dashboardUrl = '/admin/dashboard';
                            $dashboardRoute = 'admin.dashboard';
                            break;
                        case 'guru':
                            $dashboardUrl = '/guru/dashboard';
                            $dashboardRoute = 'guru.dashboard';
                            break;
                        case 'siswa':
                            $dashboardUrl = '/siswa/dashboard';
                            $dashboardRoute = 'siswa.dashboard';
                            break;
                    }
                @endphp

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ url($dashboardUrl) }}"
                        class="nav-link {{ request()->is(trim($dashboardUrl, '/')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Menu Khusus Admin --}}
                @if ($role === 'admin')
                    <li class="nav-header text-uppercase font-weight-bold">
                        <i class="fas fa-cogs mr-2"></i>
                        Manajemen Data
                    </li>

                    {{-- Manajemen Pengguna --}}
                    <li
                        class="nav-item {{ request()->is('admin/guru*') || request()->is('admin/siswa*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('admin/guru*') || request()->is('admin/siswa*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                Manajemen Pengguna
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.guru.index') }}"
                                    class="nav-link {{ request()->is('admin/guru*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Guru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.siswa.index') }}"
                                    class="nav-link {{ request()->is('admin/siswa*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Siswa</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Manajemen Akademik --}}
                    <li
                        class="nav-item {{ request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.kelasmapel.*') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.kelasmapel.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>
                                Manajemen Akademik
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.kelas.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kelas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.mapel.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data Mapel</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.kelasmapel.index') }}"
                                    class="nav-link {{ request()->routeIs('admin.kelasmapel.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kelas Mapel</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header text-uppercase font-weight-bold">
                        <i class="fas fa-clipboard-check mr-2"></i>
                        Manajemen Ujian
                    </li>

                    {{-- Laporan --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('admin/laporan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Laporan</p>
                        </a>
                    </li>
                @endif

                {{-- Menu Khusus Guru --}}
                @if ($role === 'guru')
                    <li class="nav-header text-uppercase font-weight-bold">
                        <i class="fas fa-chalkboard-teacher mr-2"></i>
                        Menu Guru
                    </li>

                    {{-- Kelas yang dia ajar --}}
                    <li class="nav-item">
                        <a href="{{ route('guru.kelas.index') }}"
                            class="nav-link {{ request()->is('guru/kelas*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Kelas Saya</p>
                        </a>
                    </li>

                    {{-- Materi untuk kelas-mapel --}}
                    <li class="nav-item">
                        <a href="{{ route('guru.materi.index') }}"
                            class="nav-link {{ request()->is('guru/materi*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Materi</p>
                        </a>
                    </li>

                    {{-- Tugas untuk kelas-mapel --}}
                    <li class="nav-item">
                        <a href="{{ route('guru.tugas.index') }}"
                            class="nav-link {{ request()->is('guru/tugas*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Tugas</p>
                        </a>
                    </li>

                    {{-- Opsional: Rekap nilai siswa --}}
                    {{-- <li class="nav-item">
                        <a href="{{ route('guru.nilai.index') }}"
                            class="nav-link {{ request()->is('guru/nilai*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Rekap Nilai</p>
                        </a>
                    </li> --}}
                @endif



                {{-- Menu Khusus Siswa --}}
                @if ($role === 'siswa')
                    <li class="nav-header text-uppercase font-weight-bold">
                        <i class="fas fa-user-graduate mr-2"></i>
                        Menu Siswa
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('siswa/jadwal*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Jadwal Ujian</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('siswa/ujian*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>Ujian Saya</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('siswa/hasil*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Hasil & Nilai</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>

{{-- Form Logout tersembunyi --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

{{-- Custom Styles untuk Sidebar --}}
<style>
    .sidebar .nav-header {
        color: #ffffffff;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        margin-top: 1rem;
        margin-bottom: 0.5rem;
    }

    .sidebar .nav-link {
        color: #ffffffff;
        transition: all 0.3s ease;
        border-radius: 0.25rem;
        margin: 0.1rem 0rem;
    }

    .sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateX(3px);
    }

    .sidebar .nav-link.active {
        background-color: #007bff !important;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
    }

    .sidebar .nav-treeview .nav-link {
        padding-left: 1rem;
        font-size: 0.9rem;
    }

    .sidebar .nav-treeview .nav-link.active {
        background-color: rgba(0, 123, 255, 0.8) !important;
    }

    .user-panel {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .user-panel .info small {
        font-size: 0.8rem;
        opacity: 0.8;
    }

    .brand-link {
        transition: all 0.3s ease;
    }

    .brand-link:hover {
        opacity: 0.9;
    }

    /* Style khusus untuk menu logout */
    .nav-link .text-danger {
        font-weight: 500;
    }

    .nav-link:hover .text-danger {
        color: #ff6b6b !important;
    }

    /* Responsive adjustments */
    @media (max-width: 767px) {
        .brand-text {
            font-size: 0.9rem;
        }

        .sidebar .nav-link p {
            font-size: 0.85rem;
        }
    }

    /* Menu active state improvements */
    .nav-item.menu-open>.nav-link {
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    .nav-item.menu-open>.nav-link .right {
        transform: rotate(-90deg);
        transition: transform 0.3s ease;
    }
</style>