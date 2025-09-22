@extends('layouts.admin')

@section('title', 'SoalUjian')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 text-gray-800">Manajemen Ujian</h1>

            <!-- Tombol Tambah Ujian -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahUjianModal">
                Tambah Ujian
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertSuccess">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertError">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertValidation">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Mata Pelajaran</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Soal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ujians as $ujian)
                    <tr>
                        <td>{{ $ujian->judul }}</td>
                        <td>{{ $ujian->mapel->nama }}</td>
                        <td>{{ $ujian->waktu_mulai }}</td>
                        <td>{{ $ujian->waktu_selesai }}</td>
                        <td>
                            <a href="{{ route('guru.ujian.edit', $ujian->id) }}" class="btn btn-sm btn-info">
                                Kelola Soal
                            </a>
                        </td>
                        <td>
                            <!-- Tombol Edit -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editUjianModal{{ $ujian->id }}">
                                Edit
                            </button>

                            <!-- Tombol Delete -->
                            <form action="{{ route('guru.ujian.destroy', $ujian->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin hapus ujian ini?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit Ujian -->
                    <div class="modal fade" id="editUjianModal{{ $ujian->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('guru.ujian.update', $ujian->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Ujian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label>Mata Pelajaran</label>
                                            <select name="mapel_id" class="form-control" required>
                                                @foreach ($mapels as $mapel)
                                                    <option value="{{ $mapel->id }}"
                                                        {{ $ujian->mapel_id == $mapel->id ? 'selected' : '' }}>
                                                        {{ $mapel->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Judul</label>
                                            <input type="text" name="judul" class="form-control"
                                                value="{{ $ujian->judul }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Waktu Mulai</label>
                                            <input type="datetime-local" name="waktu_mulai" class="form-control"
                                                value="{{ date('Y-m-d\TH:i', strtotime($ujian->waktu_mulai)) }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label>Waktu Selesai</label>
                                            <input type="datetime-local" name="waktu_selesai" class="form-control"
                                                value="{{ date('Y-m-d\TH:i', strtotime($ujian->waktu_selesai)) }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Ujian -->
    <div class="modal fade" id="tambahUjianModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('guru.ujian.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Ujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Mata Pelajaran</label>
                            <select name="mapel_id" class="form-control" required>
                                <option value="">Pilih Mata Pelajaran</option>
                                @foreach ($mapels as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Waktu Mulai</label>
                            <input type="datetime-local" name="waktu_mulai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Waktu Selesai</label>
                            <input type="datetime-local" name="waktu_selesai" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-success">Tambah Ujian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Tutup otomatis setelah 2 detik
                ['alertSuccess', 'alertError', 'alertValidation'].forEach(function(id) {
                    let alertBox = document.getElementById(id);
                    if (alertBox) {
                        setTimeout(() => {
                            let alert = new bootstrap.Alert(alertBox);
                            alert.close();
                        }, 2000);
                    }
                });
            });
        </script>
    @endpush
@endsection
