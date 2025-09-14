@extends('layouts.admin')

@section('title', 'Dashboard Guru')

@section('content')
    <div class="container-fluid">
        <!-- Header Welcome -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-gradient-primary text-white rounded-3 p-4 shadow">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="h3 mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                            <p class="mb-0 opacity-75">
                                <i
                                    class="fas fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                            </p>
                            <small class="opacity-75">Mari mulai hari yang produktif untuk mengajar siswa-siswa
                                terbaik!</small>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-inline-block bg-white bg-opacity-20 rounded-3 p-3">
                                <i class="fas fa-chalkboard-teacher fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <!-- Total Kelas -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-uppercase text-muted fw-bold text-xs mb-1">Total Kelas</div>
                                <div class="h5 fw-bold text-gray-800 mb-0">{{ $totalKelas ?? 8 }}</div>
                                <div class="text-xs text-success">
                                    <i class="fas fa-arrow-up me-1"></i>Aktif
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="bg-primary bg-gradient rounded-circle p-3">
                                    <i class="fas fa-users text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Siswa -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-uppercase text-muted fw-bold text-xs mb-1">Total Siswa</div>
                                <div class="h5 fw-bold text-gray-800 mb-0">{{ $totalSiswa ?? 245 }}</div>
                                <div class="text-xs text-info">
                                    <i class="fas fa-user-graduate me-1"></i>Aktif
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="bg-success bg-gradient rounded-circle p-3">
                                    <i class="fas fa-user-graduate text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mata Pelajaran -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-uppercase text-muted fw-bold text-xs mb-1">Mata Pelajaran</div>
                                <div class="h5 fw-bold text-gray-800 mb-0">{{ $totalMapel ?? 5 }}</div>
                                <div class="text-xs text-primary">
                                    <i class="fas fa-book me-1"></i>Diampu
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="bg-info bg-gradient rounded-circle p-3">
                                    <i class="fas fa-book text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ujian Berlangsung -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-uppercase text-muted fw-bold text-xs mb-1">Ujian Aktif</div>
                                <div class="h5 fw-bold text-gray-800 mb-0">{{ $ujianAktif ?? 3 }}</div>
                                <div class="text-xs text-warning">
                                    <i class="fas fa-clock me-1"></i>Berlangsung
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="bg-warning bg-gradient rounded-circle p-3">
                                    <i class="fas fa-clipboard-list text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-xl-8 col-lg-7">
                <!-- Jadwal Mengajar Hari Ini -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 fw-bold text-primary">
                                    <i class="fas fa-calendar-check me-2"></i>Jadwal Mengajar Hari Ini
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            $jadwalHariIni = [
                                [
                                    'waktu' => '07:30 - 09:00',
                                    'mapel' => 'Matematika',
                                    'kelas' => 'X-1',
                                    'ruang' => 'R.101',
                                    'status' => 'upcoming',
                                ],
                                [
                                    'waktu' => '09:15 - 10:45',
                                    'mapel' => 'Fisika',
                                    'kelas' => 'XI-2',
                                    'ruang' => 'Lab. Fisika',
                                    'status' => 'ongoing',
                                ],
                                [
                                    'waktu' => '11:00 - 12:30',
                                    'mapel' => 'Matematika',
                                    'kelas' => 'X-2',
                                    'ruang' => 'R.102',
                                    'status' => 'upcoming',
                                ],
                                [
                                    'waktu' => '13:30 - 15:00',
                                    'mapel' => 'Fisika',
                                    'kelas' => 'XII-1',
                                    'ruang' => 'Lab. Fisika',
                                    'status' => 'upcoming',
                                ],
                            ];
                        @endphp

                        @forelse($jadwalHariIni as $jadwal)
                            <div class="d-flex align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="flex-shrink-0">
                                    <div
                                        class="bg-{{ $jadwal['status'] === 'ongoing' ? 'success' : ($jadwal['status'] === 'completed' ? 'secondary' : 'primary') }} bg-gradient rounded-circle p-2">
                                        <i
                                            class="fas fa-{{ $jadwal['status'] === 'ongoing' ? 'play' : ($jadwal['status'] === 'completed' ? 'check' : 'clock') }} text-white fa-sm"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="fw-bold text-primary">{{ $jadwal['waktu'] }}</div>
                                            <small class="text-muted">{{ $jadwal['ruang'] }}</small>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="fw-semibold">{{ $jadwal['mapel'] }}</div>
                                            <small class="text-muted">Kelas {{ $jadwal['kelas'] }}</small>
                                        </div>
                                        <div class="col-md-3 text-md-end">
                                            <span
                                                class="badge bg-{{ $jadwal['status'] === 'ongoing' ? 'success' : ($jadwal['status'] === 'completed' ? 'secondary' : 'primary') }}">
                                                {{ $jadwal['status'] === 'ongoing' ? 'Berlangsung' : ($jadwal['status'] === 'completed' ? 'Selesai' : 'Akan Datang') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada jadwal mengajar hari ini</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tugas & Ujian Terbaru -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 fw-bold text-primary">
                            <i class="fas fa-tasks me-2"></i>Tugas & Ujian Terbaru
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Jenis</th>
                                        <th>Judul</th>
                                        <th>Kelas</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $tugasUjian = [
                                            [
                                                'jenis' => 'Tugas',
                                                'judul' => 'Soal Matematika Bab 5',
                                                'kelas' => 'X-1',
                                                'deadline' => '2025-09-20',
                                                'status' => 'active',
                                            ],
                                            [
                                                'jenis' => 'Ujian',
                                                'judul' => 'UTS Fisika Semester 1',
                                                'kelas' => 'XI-2',
                                                'deadline' => '2025-09-22',
                                                'status' => 'upcoming',
                                            ],
                                            [
                                                'jenis' => 'Tugas',
                                                'judul' => 'Praktikum Lab',
                                                'kelas' => 'XII-1',
                                                'deadline' => '2025-09-18',
                                                'status' => 'overdue',
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($tugasUjian as $item)
                                        <tr>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $item['jenis'] === 'Tugas' ? 'info' : 'warning' }}">
                                                    <i
                                                        class="fas fa-{{ $item['jenis'] === 'Tugas' ? 'tasks' : 'clipboard-list' }} me-1"></i>
                                                    {{ $item['jenis'] }}
                                                </span>
                                            </td>
                                            <td class="fw-semibold">{{ $item['judul'] }}</td>
                                            <td>{{ $item['kelas'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item['deadline'])->translatedFormat('d M Y') }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $item['status'] === 'active' ? 'success' : ($item['status'] === 'overdue' ? 'danger' : 'secondary') }}">
                                                    {{ $item['status'] === 'active' ? 'Aktif' : ($item['status'] === 'overdue' ? 'Terlambat' : 'Akan Datang') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-outline-primary" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-success" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-xl-4 col-lg-5">
                <!-- Quick Actions -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 fw-bold text-primary">
                            <i class="fas fa-bolt me-2"></i>Aksi Cepat
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>Buat Tugas Baru
                            </button>
                            <button class="btn btn-success">
                                <i class="fas fa-clipboard-list me-2"></i>Buat Ujian Baru
                            </button>
                            <button class="btn btn-info">
                                <i class="fas fa-upload me-2"></i>Upload Materi
                            </button>
                            <button class="btn btn-warning">
                                <i class="fas fa-chart-bar me-2"></i>Lihat Nilai Siswa
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pengumuman -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 fw-bold text-primary">
                            <i class="fas fa-bullhorn me-2"></i>Pengumuman
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $pengumuman = [
                                ['judul' => 'Rapat Koordinasi Guru', 'tanggal' => '2025-09-15', 'penting' => true],
                                [
                                    'judul' => 'Pelatihan Kurikulum Merdeka',
                                    'tanggal' => '2025-09-18',
                                    'penting' => false,
                                ],
                                ['judul' => 'Evaluasi Tengah Semester', 'tanggal' => '2025-09-20', 'penting' => true],
                            ];
                        @endphp

                        @foreach ($pengumuman as $item)
                            <div class="d-flex align-items-start py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="flex-shrink-0">
                                    <div
                                        class="bg-{{ $item['penting'] ? 'danger' : 'info' }} bg-gradient rounded-circle p-1">
                                        <i
                                            class="fas fa-{{ $item['penting'] ? 'exclamation' : 'info' }} text-white fa-xs"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <div class="fw-semibold text-sm">{{ $item['judul'] }}</div>
                                    <small
                                        class="text-muted">{{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d M Y') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer bg-white">
                        <a href="#" class="text-primary text-decoration-none fw-semibold">
                            Lihat Semua Pengumuman <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Statistik Kelas -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 fw-bold text-primary">
                            <i class="fas fa-chart-pie me-2"></i>Statistik Kelas
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border-end">
                                    <div class="h4 fw-bold text-primary mb-1">95%</div>
                                    <div class="text-xs text-muted">Kehadiran</div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="h4 fw-bold text-success mb-1">87%</div>
                                <div class="text-xs text-muted">Nilai Rata-rata</div>
                            </div>
                            <div class="col-6">
                                <div class="border-end">
                                    <div class="h4 fw-bold text-info mb-1">24</div>
                                    <div class="text-xs text-muted">Tugas Selesai</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="h4 fw-bold text-warning mb-1">3</div>
                                <div class="text-xs text-muted">Tugas Pending</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .bg-gradient-primary {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .card {
                border: none;
                transition: transform 0.2s ease-in-out;
            }

            .card:hover {
                transform: translateY(-2px);
            }

            .text-xs {
                font-size: 0.75rem;
            }

            .text-sm {
                font-size: 0.875rem;
            }

            .bg-opacity-20 {
                --bs-bg-opacity: 0.2;
            }

            .border-end {
                border-right: 1px solid #dee2e6;
            }

            .table-hover tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
            }

            .btn-group-sm .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            @media (max-width: 768px) {
                .col-auto .bg-gradient {
                    display: none;
                }

                .card-body .row .col-md-3 {
                    margin-bottom: 0.5rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Auto refresh untuk jam
            function updateTime() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('id-ID');
                // Update jika ada elemen jam
            }

            // Update setiap detik
            setInterval(updateTime, 1000);

            // Animation untuk cards
            document.addEventListener('DOMContentLoaded', function() {
                const cards = document.querySelectorAll('.card');
                cards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 100);
                });
            });

            // Tooltip initialization
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        </script>
    @endpush
@endsection
