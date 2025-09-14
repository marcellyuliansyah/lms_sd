@extends('layouts.admin')

@section('title', 'Manajemen Mata Pelajaran')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Manajemen Mata Pelajaran</h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMapelModal">
                        <i class="fas fa-plus"></i> Tambah Mata Pelajaran
                    </button>
                </div>

                <!-- Alert Messages -->
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

                <!-- Table -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="mapelTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="30%">Nama Mata Pelajaran</th>
                                        <th width="25%">Guru Pengajar</th>
                                        <th width="20%">Kelas</th>
                                        <th width="20%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($mapel as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $item->nama }}</strong>
                                            </td>
                                            <td>
                                                @if ($item->guru)
                                                    <span class="badge bg-success">{{ $item->guru->nama }}</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Ditentukan</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->kelas)
                                                    <span class="badge bg-info">{{ $item->kelas->nama }}</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Ditentukan</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-info"
                                                        data-bs-toggle="modal" data-bs-target="#showMapelModal"
                                                        onclick="showMapel('{{ $item->nama }}', '{{ $item->guru->nama ?? 'Belum Ditentukan' }}', '{{ $item->kelas->nama ?? 'Belum Ditentukan' }}')">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal" data-bs-target="#editMapelModal"
                                                        onclick="editMapel('{{ $item->id }}', '{{ $item->nama }}', '{{ $item->guru_id }}', '{{ $item->kelas_id }}')">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal" data-bs-target="#deleteMapelModal"
                                                        onclick="deleteMapel('{{ $item->id }}', '{{ $item->nama }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-book fa-3x mb-3"></i>
                                                    <p>Belum ada data mata pelajaran</p>
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

    <!-- Modal Tambah Mata Pelajaran -->
    <div class="modal fade" id="addMapelModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.mapel.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="nama" class="form-label">Nama Mata Pelajaran <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="guru_id" class="form-label">Guru Pengajar <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('guru_id') is-invalid @enderror" id="guru_id"
                                    name="guru_id" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach ($gurus ?? [] as $guru)
                                        <option value="{{ $guru->id }}"
                                            {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                            {{ $guru->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guru_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kelas_id" class="form-label">Kelas <span class="text-danger">*</span></label>
                                <select class="form-select @error('kelas_id') is-invalid @enderror" id="kelas_id"
                                    name="kelas_id" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas ?? [] as $kelasItem)
                                        <option value="{{ $kelasItem->id }}"
                                            {{ old('kelas_id') == $kelasItem->id ? 'selected' : '' }}>
                                            {{ $kelasItem->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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

    <!-- Modal Edit Mata Pelajaran -->
    <div class="modal fade" id="editMapelModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="edit_nama" class="form-label">Nama Mata Pelajaran <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama" name="nama" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_guru_id" class="form-label">Guru Pengajar <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="edit_guru_id" name="guru_id" required>
                                    <option value="">Pilih Guru</option>
                                    @foreach ($gurus ?? [] as $guru)
                                        <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_kelas_id" class="form-label">Kelas <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="edit_kelas_id" name="kelas_id" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas ?? [] as $kelasItem)
                                        <option value="{{ $kelasItem->id }}">{{ $kelasItem->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
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

    <!-- Modal Show Mata Pelajaran -->
    <div class="modal fade" id="showMapelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Mata Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%"><strong>Mata Pelajaran</strong></td>
                            <td>: <span id="show_nama"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Guru Pengajar</strong></td>
                            <td>: <span id="show_guru"></span></td>
                        </tr>
                        <tr>
                            <td><strong>Kelas</strong></td>
                            <td>: <span id="show_kelas"></span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete Mata Pelajaran -->
    <div class="modal fade" id="deleteMapelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Hapus Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                        </div>
                        <p>Apakah Anda yakin ingin menghapus mata pelajaran <strong id="delete_nama"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function editMapel(id, nama, guruId, kelasId) {
                document.getElementById('editForm').action = '{{ url('admin/mapel') }}/' + id;
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_guru_id').value = guruId || '';
                document.getElementById('edit_kelas_id').value = kelasId || '';
            }

            function showMapel(nama, guru, kelas) {
                document.getElementById('show_nama').textContent = nama;
                document.getElementById('show_guru').textContent = guru;
                document.getElementById('show_kelas').textContent = kelas;
            }

            function deleteMapel(id, nama) {
                document.getElementById('deleteForm').action = '{{ url('admin/mapel') }}/' + id;
                document.getElementById('delete_nama').textContent = nama;
            }

            // Load guru and kelas data for modals
            let guruData = @json($gurus ?? []);
            let kelasData = @json($kelas ?? []);

            // Populate select options
            function populateSelectOptions() {
                // For add modal
                const guruSelect = document.getElementById('guru_id');
                const kelasSelect = document.getElementById('kelas_id');

                // For edit modal
                const editGuruSelect = document.getElementById('edit_guru_id');
                const editKelasSelect = document.getElementById('edit_kelas_id');

                // Clear existing options (keep first option)
                [guruSelect, editGuruSelect].forEach(select => {
                    if (select) {
                        for (let i = select.options.length - 1; i > 0; i--) {
                            select.remove(i);
                        }
                    }
                });

                [kelasSelect, editKelasSelect].forEach(select => {
                    if (select) {
                        for (let i = select.options.length - 1; i > 0; i--) {
                            select.remove(i);
                        }
                    }
                });

                // Add guru options
                if (guruData && Array.isArray(guruData)) {
                    guruData.forEach(guru => {
                        if (guruSelect) {
                            const option = new Option(guru.nama, guru.id);
                            guruSelect.add(option);
                        }
                        if (editGuruSelect) {
                            const option = new Option(guru.nama, guru.id);
                            editGuruSelect.add(option);
                        }
                    });
                }

                // Add kelas options
                if (kelasData && Array.isArray(kelasData)) {
                    kelasData.forEach(kelas => {
                        if (kelasSelect) {
                            const option = new Option(kelas.nama, kelas.id);
                            kelasSelect.add(option);
                        }
                        if (editKelasSelect) {
                            const option = new Option(kelas.nama, kelas.id);
                            editKelasSelect.add(option);
                        }
                    });
                }
            }

            // Auto hide alerts after 5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, 5000);
                });

                // Populate select options
                populateSelectOptions();
            });

            // Reopen modal with errors
            @if ($errors->any())
                @if (old('_method') == 'PUT')
                    document.addEventListener('DOMContentLoaded', function() {
                        var editModal = new bootstrap.Modal(document.getElementById('editMapelModal'));
                        editModal.show();
                    });
                @else
                    document.addEventListener('DOMContentLoaded', function() {
                        var addModal = new bootstrap.Modal(document.getElementById('addMapelModal'));
                        addModal.show();
                    });
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

            .modal-lg {
                max-width: 800px;
            }
        </style>
    @endpush
@endsection
