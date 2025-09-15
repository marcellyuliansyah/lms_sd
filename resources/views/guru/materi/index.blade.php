@extends('layouts.admin')

@section('title', 'Materi')

@push('styles')
    <style>
        .btn-pill {
            border-radius: 50rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-pill:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.2);
        }

        .table thead th {
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 p-4 rounded-4"
        style="background: linear-gradient(135deg, #667eea, #764ba2); color: #fff;">
        <div>
            <h2 class="h4 fw-bold mb-1">📚 Materi Saya</h2>
            <p class="mb-0 opacity-75">Kelola materi pembelajaran Anda dengan mudah.</p>
        </div>
        <button class="btn btn-light btn-pill mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle-fill me-2"></i> Tambah Materi
        </button>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="py-3 ps-4 rounded-start-4">Judul</th>
                            <th>Deskripsi</th>
                            <th>File</th>
                            <th class="text-center rounded-end-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materis as $materi)
                            <tr>
                                <td class="ps-4">
                                    <h6 class="fw-bold mb-1">{{ $materi->judul }}</h6>
                                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>
                                        {{ $materi->created_at->format('d M Y') }}</small>
                                </td>
                                <td>{{ Str::limit($materi->deskripsi, 70) }}</td>
                                <td>
                                    @if ($materi->file)
                                        <a href="{{ asset('storage/' . $materi->file) }}" target="_blank"
                                            class="btn btn-sm btn-outline-secondary btn-pill">
                                            <i class="bi bi-eye-fill me-1"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-muted"><i class="bi bi-file-earmark-x-fill me-1"></i> Tidak
                                            ada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Edit -->
                                        <button
                                            class="btn btn-warning btn-sm btn-pill text-white d-flex align-items-center px-3"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit{{ $materi->id }}">
                                            <i class="bi bi-pencil-fill me-1"></i> Edit
                                        </button>

                                        <!-- Delete -->
                                        <button class="btn btn-danger btn-sm btn-pill d-flex align-items-center px-3"
                                            data-bs-toggle="modal" data-bs-target="#modalDelete{{ $materi->id }}">
                                            <i class="bi bi-trash-fill me-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEdit{{ $materi->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('guru.materi.update', $materi->id) }}" method="POST"
                                        enctype="multipart/form-data" class="modal-content">
                                        @csrf @method('PUT')
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit
                                                Materi</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Judul</label>
                                                <input type="text" name="judul" class="form-control rounded-3"
                                                    value="{{ $materi->judul }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Deskripsi</label>
                                                <textarea name="deskripsi" class="form-control rounded-3">{{ $materi->deskripsi }}</textarea>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label fw-bold">File (opsional)</label>
                                                <input type="file" name="file" class="form-control rounded-3">
                                                @if ($materi->file)
                                                    <small class="text-muted d-block mt-2">File saat ini:
                                                        <a href="{{ asset('storage/' . $materi->file) }}" target="_blank"
                                                            class="text-decoration-none">{{ basename($materi->file) }}</a>
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0">
                                            <button type="button" class="btn btn-secondary btn-pill"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit"
                                                class="btn btn-primary btn-pill fw-semibold">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Modal Delete -->
                            <div class="modal fade" id="modalDelete{{ $materi->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center p-4">
                                            <i class="bi bi-trash-fill text-danger fs-1 mb-3"></i>
                                            <p>Apakah Anda yakin ingin menghapus <strong>{{ $materi->judul }}</strong>?</p>
                                        </div>
                                        <div class="modal-footer justify-content-between border-top-0">
                                            <button type="button" class="btn btn-secondary btn-pill"
                                                data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('guru.materi.destroy', $materi->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger btn-pill fw-semibold">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox-fill fs-1"></i>
                                    <p class="mt-2 mb-0">Belum ada materi yang ditambahkan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Materi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul</label>
                        <input type="text" name="judul" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control rounded-3"></textarea>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-bold">File (opsional)</label>
                        <input type="file" name="file" class="form-control rounded-3"
                            accept=".pdf,.doc,.docx,.ppt,.pptx">
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-pill fw-semibold">Tambah</button>
                </div>
            </form>
        </div>
    </div>
@endsection
