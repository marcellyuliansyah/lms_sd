@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="bg-gradient-navy text-white rounded-3 p-3 mb-3 shadow">
                    <div class="row align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3">
                                <i class="fas fa-school"></i> Manajemen Kelas
                            </h1>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addKelasModal">
                                <i class="fas fa-plus-circle"></i> Tambah Kelas
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Table -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="kelasTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Kelas</th>
                                        <th width="30%">Wali Kelas</th>
                                        <th width="20%">Jumlah Siswa</th>
                                        <th width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kelas as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $item->nama }}</strong>
                                            </td>
                                            <td>
                                                @if ($item->waliKelas)
                                                    <span class="badge bg-success">{{ $item->waliKelas->nama }}</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Ditentukan</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $item->siswas_count }} Siswa</span>
                                            </td>
                                            <td>
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#showKelasModal"
                                                        onclick="showKelas('{{ $item->id }}', '{{ $item->nama }}', '{{ $item->waliKelas ? $item->waliKelas->nama : 'Belum Ditentukan' }}', '{{ $item->siswas_count }}')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#editKelasModal"
                                                        onclick="editKelas('{{ $item->id }}', '{{ $item->nama }}', '{{ $item->wali_kelas_id }}')">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteKelasModal"
                                                        onclick="deleteKelas('{{ $item->id }}', '{{ $item->nama }}', '{{ $item->siswas_count }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                                    <p>Belum ada data kelas</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kelas -->
    <div class="modal fade" id="addKelasModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.kelas.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kelas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="wali_kelas_id" class="form-label">Wali Kelas</label>
                            <select class="form-select @error('wali_kelas_id') is-invalid @enderror" id="wali_kelas_id"
                                name="wali_kelas_id">
                                <option value="">Pilih Wali Kelas (Opsional)</option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ old('wali_kelas_id') == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('wali_kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kelas -->
    <div class="modal fade" id="editKelasModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kelas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_wali_kelas_id" class="form-label">Wali Kelas</label>
                            <select class="form-select" id="edit_wali_kelas_id" name="wali_kelas_id">
                                <option value="">Pilih Wali Kelas (Opsional)</option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Show Kelas -->
    <div class="modal fade" id="showKelasModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%"><strong>Nama Kelas</strong></td>
                            <td>: <span id="show_nama"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Wali Kelas</strong></td>
                            <td>: <span id="show_wali_kelas"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Jumlah Siswa</strong></td>
                            <td>: <span id="show_jumlah_siswa"></span> siswa</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete Kelas -->
    <div class="modal fade" id="deleteKelasModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Hapus Kelas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                        </div>
                        <p>Apakah Anda yakin ingin menghapus kelas <strong id="delete_nama"></strong>?</p>
                        <div id="delete_warning" style="display: none;">
                            <div class="alert alert-danger">
                                <i class="fas fa-times-circle"></i>
                                Kelas ini masih memiliki <strong id="delete_jumlah_siswa"></strong> siswa dan tidak
                                dapat
                                dihapus.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function editKelas(id, nama, waliKelasId) {
                document.getElementById('editForm').action = '{{ url('admin/kelas') }}/' + id;
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_wali_kelas_id').value = waliKelasId || '';
            }

            function showKelas(id, nama, waliKelas, jumlahSiswa) {
                document.getElementById('show_nama').textContent = nama;
                document.getElementById('show_wali_kelas').textContent = waliKelas;
                document.getElementById('show_jumlah_siswa').textContent = jumlahSiswa;
            }

            function deleteKelas(id, nama, jumlahSiswa) {
                document.getElementById('deleteForm').action = '{{ url('admin/kelas') }}/' + id;
                document.getElementById('delete_nama').textContent = nama;
                document.getElementById('delete_jumlah_siswa').textContent = jumlahSiswa;

                const warningDiv = document.getElementById('delete_warning');
                const confirmBtn = document.getElementById('confirmDeleteBtn');

                if (parseInt(jumlahSiswa) > 0) {
                    warningDiv.style.display = 'block';
                    confirmBtn.style.display = 'none';
                } else {
                    warningDiv.style.display = 'none';
                    confirmBtn.style.display = 'inline-block';
                }
            }

            // Auto hide alerts after 5 seconds
            document.addEventListener('DOMContentLoaded', function () {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function (alert) {
                    setTimeout(function () {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, 2000);
                });
            });

            // Reopen modal with errors
            @if ($errors->any())
                @if (old('_method') == 'PUT')
                    var editModal = new bootstrap.Modal(document.getElementById('editKelasModal'));
                    editModal.show();
                @else
                    var addModal = new bootstrap.Modal(document.getElementById('addKelasModal'));
                    addModal.show();
                @endif
            @endif
        </script>
    @endpush

    @push('styles')
        <style>
            .table th {
                font-weight: 600;
                font-size: 0.9rem;
            }

            .btn-group .btn {
                margin-right: 2px;
            }

            .btn-group .btn:last-child {
                margin-right: 0;
            }

            .modal-header {
                border-bottom: 2px solid #dee2e6;
            }

            .modal-footer {
                border-top: 2px solid #dee2e6;
            }

            .badge {
                font-size: 0.8rem;
            }

            .card {
                border: none;
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            }

            .table-responsive {
                border-radius: 0.35rem;
            }
        </style>
    @endpush
@endsection