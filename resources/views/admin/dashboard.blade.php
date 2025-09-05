@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    <!-- Judul Halaman -->
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3">Selamat Datang, <b>{{ Auth::user()->name }}</b> 👋</h1>
            <p class="text-muted">
                Anda login sebagai 
                <span class="badge bg-primary">{{ Auth::user()->role }}</span>
            </p>
        </div>
    </div>

    <!-- Statistik / Info Box -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>80</h3>
                    <p>Guru</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat Detail 
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>580</h3>
                    <p>Siswa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat Detail 
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>24</h3>
                    <p>Kelas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-school"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat Detail 
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>30</h3>
                    <p>Mata Pelajaran</p>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat Detail 
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
