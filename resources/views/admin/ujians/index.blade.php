@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">📅 Manajemen Jadwal Ujian</h5>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-circle"></i> Tambah Ujian
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ujians as $ujian)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ujian->judul }}</td>
                                    <td>{{ $ujian->mapel->nama ?? '-' }}</td>
                                    <td>{{ $ujian->guru->name ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ujian->waktu_mulai)->format('d M Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($ujian->waktu_selesai)->format('d M Y H:i') }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $ujian->status == 'published' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($ujian->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            {{-- Tombol Edit --}}
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $ujian->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            {{-- Tombol Delete --}}
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $ujian->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            {{-- Tombol Publish --}}
                                            @if ($ujian->status == 'draft')
                                                <form action="{{ route('admin.ujians.publish', $ujian->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="bi bi-upload"></i> Publish
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- Modal Edit --}}
                                <div class="modal fade" id="editModal{{ $ujian->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.ujians.update', $ujian->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title">Edit Ujian</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Judul Ujian</label>
                                                        <input type="text" name="judul" class="form-control"
                                                            value="{{ $ujian->judul }}" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Mata Pelajaran</label>
                                                            <select name="mapel_id" class="form-select" required>
                                                                <option value="">-- Pilih Mapel --</option>
                                                                @foreach ($mapels as $mapel)
                                                                    <option value="{{ $mapel->id }}"
                                                                        {{ $mapel->id == $ujian->mapel_id ? 'selected' : '' }}>
                                                                        {{ $mapel->nama }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Guru</label>
                                                            <select name="guru_id" class="form-select" required>
                                                                <option value="">-- Pilih Guru --</option>
                                                                @foreach ($gurus as $guru)
                                                                    <option value="{{ $guru->id }}"
                                                                        {{ $guru->id == $ujian->guru_id ? 'selected' : '' }}>
                                                                        {{ $guru->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Waktu Mulai</label>
                                                            <input type="datetime-local" name="waktu_mulai"
                                                                class="form-control"
                                                                value="{{ \Carbon\Carbon::parse($ujian->waktu_mulai)->format('Y-m-d\TH:i') }}"
                                                                required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Waktu Selesai</label>
                                                            <input type="datetime-local" name="waktu_selesai"
                                                                class="form-control"
                                                                value="{{ \Carbon\Carbon::parse($ujian->waktu_selesai)->format('Y-m-d\TH:i') }}"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Delete --}}
                                <div class="modal fade" id="deleteModal{{ $ujian->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.ujians.destroy', $ujian->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Hapus Ujian</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Yakin ingin menghapus ujian <strong>{{ $ujian->judul }}</strong> ?
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada jadwal ujian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.ujians.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Jadwal Ujian</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Ujian</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mata Pelajaran</label>
                                <select name="mapel_id" class="form-select" required>
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach ($mapels as $mapel)
                                        <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guru</label>
                                <select name="guru_id" class="form-select" required>
                                    <option value="">-- Pilih Guru --</option>
                                    @foreach ($gurus as $guru)
                                        <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="datetime-local" name="waktu_mulai" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="datetime-local" name="waktu_selesai" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah Ujian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
