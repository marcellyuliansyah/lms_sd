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
            border: none;
        }

        .table tbody td {
            border-top: 1px solid #e9ecef;
            vertical-align: middle;
        }

        .action-buttons {
            min-width: 140px;
        }

        .modal-header {
            border-radius: 1rem 1rem 0 0 !important;
        }

        .form-control {
            border: 2px solid #e9ecef;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.1);
        }

        .file-info {
            background-color: #f8f9fa;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            border-left: 4px solid #007bff;
        }

        .empty-state {
            padding: 3rem 1rem;
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

    <!-- Notifikasi Berhasil -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="py-3 ps-4 rounded-start-4">Judul Materi</th>
                            <th>Deskripsi</th>
                            <th class="text-center">File</th>
                            <th class="text-center rounded-end-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materis as $materi)
                            <tr>
                                <td class="ps-4" style="min-width: 200px;">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $materi->judul }}</h6>
                                        <small class="text-muted d-flex align-items-center">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $materi->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                </td>
                                <td style="max-width: 250px;">
                                    @if ($materi->deskripsi)
                                        <span class="text-muted">{{ Str::limit($materi->deskripsi, 80) }}</span>
                                    @else
                                        <em class="text-muted">Tidak ada deskripsi</em>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($materi->file)
                                        <a href="{{ asset('storage/' . $materi->file) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary btn-pill">
                                            <i class="bi bi-file-earmark-text me-1"></i> Lihat File
                                        </a>
                                    @else
                                        <span class="badge bg-light text-muted">
                                            <i class="bi bi-file-earmark-x me-1"></i> Tidak ada file
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center action-buttons">
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- Edit Button -->
                                        <button type="button"
                                            class="btn btn-warning btn-sm btn-pill text-white d-flex align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit{{ $materi->id }}"
                                            title="Edit Materi">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>

                                        <!-- Delete Button -->
                                        <button type="button"
                                            class="btn btn-danger btn-sm btn-pill d-flex align-items-center"
                                            data-bs-toggle="modal" data-bs-target="#modalDelete{{ $materi->id }}"
                                            title="Hapus Materi">
                                            <i class="bi bi-trash3 me-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center empty-state">
                                    <div class="text-muted">
                                        <i class="bi bi-folder2-open display-4 mb-3"></i>
                                        <h5>Belum Ada Materi</h5>
                                        <p class="mb-3">Mulai tambahkan materi pembelajaran Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Materi -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold" id="modalTambahLabel">
                            <i class="bi bi-plus-circle-fill me-2"></i> Tambah Materi Baru
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="judul" class="form-label fw-bold">
                                    <i class="bi bi-bookmark-fill text-primary me-1"></i> Judul Materi
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="judul" id="judul" class="form-control"
                                    placeholder="Masukkan judul materi" required maxlength="255">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="deskripsi" class="form-label fw-bold">
                                    <i class="bi bi-card-text text-primary me-1"></i> Deskripsi
                                </label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"
                                    placeholder="Berikan deskripsi singkat tentang materi ini (opsional)"></textarea>
                            </div>
                            <div class="col-12 mb-0">
                                <label for="file" class="form-label fw-bold">
                                    <i class="bi bi-cloud-upload text-primary me-1"></i> File Materi
                                </label>
                                <input type="file" name="file" id="file" class="form-control"
                                    accept=".pdf,.doc,.docx,.ppt,.pptx">
                                <div class="form-text">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Format yang didukung: PDF, DOC, DOCX, PPT, PPTX (Maks: 10MB)
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary btn-pill">
                            <i class="bi bi-check-circle me-2"></i> Simpan Materi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit & Delete untuk setiap materi -->
    @foreach ($materis as $materi)
        <!-- Modal Edit -->
        <div class="modal fade" id="modalEdit{{ $materi->id }}" tabindex="-1"
            aria-labelledby="modalEditLabel{{ $materi->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="{{ route('guru.materi.update', $materi->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title fw-bold" id="modalEditLabel{{ $materi->id }}">
                                <i class="bi bi-pencil-square me-2"></i> Edit Materi
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="judul{{ $materi->id }}" class="form-label fw-bold">
                                        <i class="bi bi-bookmark-fill text-warning me-1"></i> Judul Materi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="judul" id="judul{{ $materi->id }}"
                                        class="form-control" value="{{ old('judul', $materi->judul) }}" required
                                        maxlength="255">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="deskripsi{{ $materi->id }}" class="form-label fw-bold">
                                        <i class="bi bi-card-text text-warning me-1"></i> Deskripsi
                                    </label>
                                    <textarea name="deskripsi" id="deskripsi{{ $materi->id }}" class="form-control" rows="4">{{ old('deskripsi', $materi->deskripsi) }}</textarea>
                                </div>
                                <div class="col-12 mb-0">
                                    <label for="file{{ $materi->id }}" class="form-label fw-bold">
                                        <i class="bi bi-cloud-upload text-warning me-1"></i> File Materi
                                    </label>
                                    @if ($materi->file)
                                        <div class="file-info mb-2">
                                            <small class="d-block fw-semibold">File saat ini:</small>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="text-muted">{{ basename($materi->file) }}</span>
                                                <a href="{{ asset('storage/' . $materi->file) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> Lihat
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    <input type="file" name="file" id="file{{ $materi->id }}"
                                        class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx">
                                    <div class="form-text">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Biarkan kosong jika tidak ingin mengubah file.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-2"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-warning btn-pill text-white">
                                <i class="bi bi-check-circle me-2"></i> Update Materi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div class="modal fade" id="modalDelete{{ $materi->id }}" tabindex="-1"
            aria-labelledby="modalDeleteLabel{{ $materi->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title fw-bold" id="modalDeleteLabel{{ $materi->id }}">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Hapus
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-4">
                        <div class="mb-3">
                            <i class="bi bi-trash3-fill text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="mb-3">Hapus Materi Ini?</h6>
                        <p class="text-muted mb-2">
                            Anda akan menghapus materi <strong>"{{ $materi->judul }}"</strong>
                        </p>
                        <div class="alert alert-warning">
                            <small>
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan!
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary btn-pill" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i> Batal
                        </button>
                        <form action="{{ route('guru.materi.destroy', $materi->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-pill">
                                <i class="bi bi-trash3 me-2"></i> Ya, Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 200);
                }, 2000);
            });
        });

        // File input change handler
        document.querySelectorAll('input[type="file"]').forEach(function(input) {
            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.size > 10 * 1024 * 1024) { // 10MB
                    alert('Ukuran file terlalu besar! Maksimal 10MB.');
                    this.value = '';
                }
            });
        });
    </script>
@endpush
