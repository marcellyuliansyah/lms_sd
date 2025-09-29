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
                            Total: {{ $kelasSaya->count() }} Kelas
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if ($kelasSaya->isEmpty())
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
                                Saat ini belum ada data kelas yang Anda ampu. Hubungi administrator untuk menambahkan.
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
                                    <h3 class="mb-0">{{ $kelasSaya->count() }}</h3>
                                </div>
                                <i class="fas fa-school fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bisa tambahkan statistik lain sesuai kebutuhan -->
            </div>

            <!-- Kelas Cards Grid View -->
            <div id="kelasGrid" class="row">
                @foreach ($kelasSaya as $km)
                    <div class="col-lg-4 col-md-6 mb-4 kelas-item"
                         data-nama="{{ strtolower($km->kelas->nama) }}">
                        <div class="card h-100 shadow-sm border-0 position-relative overflow-hidden">

                            <!-- Card Header -->
                            <div class="card-header bg-gradient-primary text-white">
                                <h5 class="card-title mb-0">{{ $km->kelas->nama }}</h5>
                                <small class="opacity-75">{{ $km->mapel->nama }}</small>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <p><strong>Mata Pelajaran:</strong> {{ $km->mapel->nama }}</p>
                                <p><strong>Kelas:</strong> {{ $km->kelas->nama }}</p>
                            </div>

                            <!-- Action Button -->
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('guru.kelas.show', $km->id) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
