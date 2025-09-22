@extends('layouts.admin')

@section('title', 'Kelas Saya')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-primary mb-1">Kelas Saya</h2>
                        <p class="text-muted mb-0">Kelola dan pantau kelas yang Anda ampu</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-light text-dark me-2">
                            <i class="fas fa-chalkboard-teacher me-1"></i>
                            Total: {{ $kelas->count() }} Kelas
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if ($kelas->isEmpty())
            <!-- Empty State -->
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body py-5">
                            <div class="mb-4">
                                <i class="fas fa-school fa-4x text-muted"></i>
                            </div>
                            <h4 class="text-muted mb-3">Belum Ada Kelas</h4>
                            <p class="text-muted mb-4">
                                Saat ini belum ada data kelas dalam sistem. Hubungi administrator untuk menambahkan kelas.
                            </p>
                            <button class="btn btn-outline-primary" onclick="location.reload()">
                                <i class="fas fa-sync-alt me-2"></i>Refresh Halaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-1 opacity-75">Total Kelas</h6>
                                    <h3 class="mb-0">{{ $kelas->count() }}</h3>
                                </div>
                                <i class="fas fa-school fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-1 opacity-75">Wali Kelas</h6>
                                    <h3 class="mb-0">{{ $kelas->where('wali_kelas_id', $guru->id)->count() }}</h3>
                                </div>
                                <i class="fas fa-user-tie fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-1 opacity-75">Kelas Aktif</h6>
                                    <h3 class="mb-0">{{ $kelas->count() }}</h3>
                                </div>
                                <i class="fas fa-chart-line fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-title mb-1 opacity-75">Tahun Ajaran</h6>
                                    <h3 class="mb-0">{{ date('Y') }}</h3>
                                </div>
                                <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body py-3">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control border-start-0"
                                            placeholder="Cari kelas..." id="searchKelas">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select" id="filterWali">
                                        <option value="">Semua Kelas</option>
                                        <option value="wali">Kelas Wali Saya</option>
                                        <option value="bukan-wali">Kelas Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="view" id="gridView" checked>
                                        <label class="btn btn-outline-primary" for="gridView">
                                            <i class="fas fa-th-large me-1"></i>Grid
                                        </label>
                                        <input type="radio" class="btn-check" name="view" id="listView">
                                        <label class="btn btn-outline-primary" for="listView">
                                            <i class="fas fa-list me-1"></i>List
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kelas Cards Grid View -->
            <div id="kelasGrid" class="row">
                @foreach ($kelas as $k)
                    <div class="col-lg-4 col-md-6 mb-4 kelas-item" data-nama="{{ strtolower($k->nama) }}"
                        data-wali="{{ $k->wali_kelas_id == $guru->id ? 'wali' : 'bukan-wali' }}">
                        <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden">
                            <!-- Card Header with Gradient -->
                            <div
                                class="card-header border-0 {{ $k->wali_kelas_id == $guru->id ? 'bg-gradient-success' : 'bg-gradient-primary' }} text-white position-relative">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title mb-1 fw-bold">{{ $k->nama }}</h5>
                                        <small class="opacity-75">Kelas Reguler</small>
                                    </div>
                                    @if ($k->wali_kelas_id == $guru->id)
                                        <span class="badge bg-white text-success fw-bold">
                                            <i class="fas fa-crown me-1"></i>WALI
                                        </span>
                                    @endif
                                </div>
                                <!-- Decorative Pattern -->
                                <div class="position-absolute top-0 end-0 opacity-10">
                                    <i class="fas fa-graduation-cap fa-3x"></i>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <!-- Wali Kelas Info -->
                                <div class="mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <i class="fas fa-user-tie text-primary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Wali Kelas</small>
                                            <span
                                                class="fw-semibold">{{ $k->waliKelas->nama ?? 'Belum Ditentukan' }}</span>
                                        </div>
                                    </div>
                                </div>


                                <!-- Stats -->
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="text-center p-2 bg-light rounded">
                                            <div class="fw-bold text-primary">{{ $k->siswas ? $k->siswas->count() : 0 }}
                                            </div>
                                            <small class="text-muted">Siswa</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center p-2 bg-light rounded">
                                            <div class="fw-bold text-info">
                                                {{ $k->mataPelajarans ? $k->mataPelajarans->count() : 0 }}</div>
                                            <small class="text-muted">Mapel</small>
                                        </div>
                                    </div>
                                </div>



                                <!-- Action Button -->
                                <div class="d-grid">
                                    <a href="{{ route('guru.kelas.show', $k->id) }}"
                                        class="btn {{ $k->wali_kelas_id == $guru->id ? 'btn-success' : 'btn-primary' }}">
                                        <i class="fas fa-eye me-2"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer bg-transparent border-top-0 pt-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        Update: {{ $k->updated_at->format('d M Y') }}
                                    </small>
                                    @if ($k->wali_kelas_id == $guru->id)
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="fas fa-star me-1"></i>Prioritas
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Kelas List View (Hidden by default) -->
            <div id="kelasList" class="d-none">
                <div class="card shadow-sm border-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Kelas</th>
                                    <th>Wali Kelas</th>
                                    <th>Jumlah Siswa</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas as $k)
                                    <tr class="kelas-item" data-nama="{{ strtolower($k->nama) }}"
                                        data-wali="{{ $k->wali_kelas_id == $guru->id ? 'wali' : 'bukan-wali' }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <i class="fas fa-school text-white"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $k->nama }}</h6>
                                                    <small class="text-muted">Kelas Reguler</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ $k->waliKelas->nama ?? 'Belum Ditentukan' }}
                                                @if ($k->wali_kelas_id == $guru->id)
                                                    <span class="badge bg-success ms-2">Wali Saya</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info">
                                                {{ $k->siswas->count() ?? 0 }} Siswa
                                            </span>
                                        </td>
                                        <td>
                                            @if ($k->wali_kelas_id == $guru->id)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-crown me-1"></i>Wali Kelas
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Kelas Lain</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('guru.kelas.show', $k->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745, #1e7e34);
        }

        .avatar-sm {
            width: 40px;
            height: 40px;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem rgba(0, 0, 0, 0.15) !important;
        }

        .kelas-item.d-none {
            display: none !important;
        }

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1);
        }

        .bg-info-subtle {
            background-color: rgba(13, 202, 240, 0.1);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchKelas');
            const filterSelect = document.getElementById('filterWali');
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');
            const kelasGrid = document.getElementById('kelasGrid');
            const kelasList = document.getElementById('kelasList');

            // Search and filter function
            function filterKelas() {
                const searchTerm = searchInput.value.toLowerCase();
                const filterValue = filterSelect.value;
                const kelasItems = document.querySelectorAll('.kelas-item');

                kelasItems.forEach(item => {
                    const nama = item.dataset.nama;
                    const waliStatus = item.dataset.wali;

                    const matchSearch = nama.includes(searchTerm);
                    const matchFilter = !filterValue || waliStatus === filterValue;

                    if (matchSearch && matchFilter) {
                        item.classList.remove('d-none');
                    } else {
                        item.classList.add('d-none');
                    }
                });
            }

            // Event listeners
            searchInput.addEventListener('keyup', filterKelas);
            filterSelect.addEventListener('change', filterKelas);

            // View toggle
            gridView.addEventListener('change', function() {
                if (this.checked) {
                    kelasGrid.classList.remove('d-none');
                    kelasList.classList.add('d-none');
                }
            });

            listView.addEventListener('change', function() {
                if (this.checked) {
                    kelasGrid.classList.add('d-none');
                    kelasList.classList.remove('d-none');
                }
            });
        });
    </script>
@endpush
