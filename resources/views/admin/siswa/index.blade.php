@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Siswa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Siswa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    {{-- Notifikasi sukses --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Sukses!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fas fa-users me-2"></i>
                                    Daftar Siswa
                                </h3>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createSiswaModal">
                                    <i class="fas fa-plus me-2"></i> Tambah Siswa
                                </button>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">Nama</th>
                                            <th width="15%">NISN</th>
                                            <th width="20%">Tanggal Lahir</th>
                                            <th width="10%">Kelas</th>
                                            <th width="10%">Email</th>
                                            <th width="10%">Password</th>
                                            <th width="10%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($siswas as $siswa)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar me-2">
                                                            <span class="badge bg-secondary rounded-circle" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                                                                {{ strtoupper(substr($siswa->nama, 0, 2)) }}
                                                            </span>
                                                        </div>
                                                        <strong>{{ $siswa->nama }}</strong>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $siswa->nisn }}</span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-calendar-alt text-muted me-1"></i>
                                                    {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}
                                                </td>
                                                <td>
                                                    @if($siswa->kelas)
                                                        <span class="badge bg-success">{{ $siswa->kelas->nama }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($siswa->user && $siswa->user->email)
                                                        <i class="fas fa-envelope text-muted me-1"></i>
                                                        {{ $siswa->user->email }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-key me-1"></i>
                                                        SDIlmj2025
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <!-- Tombol Edit -->
                                                        <button type="button" class="btn btn-sm btn-warning edit-btn"
                                                            data-id="{{ $siswa->id }}" 
                                                            data-nama="{{ $siswa->nama }}"
                                                            data-nisn="{{ $siswa->nisn }}"
                                                            data-tanggal_lahir="{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') }}"
                                                            data-kelas_id="{{ $siswa->kelas_id }}" 
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editSiswaModal"
                                                            title="Edit Siswa">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        <!-- Tombol Hapus -->
                                                        <form action="{{ route('admin.siswa.destroy', $siswa->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin hapus siswa {{ $siswa->nama }}?')"
                                                                title="Hapus Siswa">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-user-slash fa-3x mb-3"></i>
                                                        <h5>Tidak ada data siswa</h5>
                                                        <p>Klik tombol "Tambah Siswa" untuk menambah data siswa baru</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Total: {{ $siswas->count() }} siswa
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Tambah Siswa -->
    <div class="modal fade" id="createSiswaModal" tabindex="-1" aria-labelledby="createSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.siswa.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="createSiswaModalLabel">
                            <i class="fas fa-user-plus me-2"></i>
                            Tambah Siswa Baru
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nama" class="form-label fw-bold">
                                        <i class="fas fa-user text-primary me-1"></i>
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="nama" name="nama" 
                                           placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nisn" class="form-label fw-bold">
                                        <i class="fas fa-id-card text-primary me-1"></i>
                                        NISN <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="nisn" name="nisn" 
                                           placeholder="Masukkan NISN" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label fw-bold">
                                        <i class="fas fa-calendar-alt text-primary me-1"></i>
                                        Tanggal Lahir <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kelas_id" class="form-label fw-bold">
                                        <i class="fas fa-school text-primary me-1"></i>
                                        Kelas <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="kelas_id" name="kelas_id" required>
                                        <option value="" disabled selected>Pilih Kelas</option>
                                        @foreach ($kelas as $kls)
                                            <option value="{{ $kls->id }}">{{ $kls->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Info:</strong> Password default adalah "SDIlmj2025" dan akan dikirimkan melalui email.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Siswa -->
    <div class="modal fade" id="editSiswaModal" tabindex="-1" aria-labelledby="editSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title" id="editSiswaModalLabel">
                            <i class="fas fa-user-edit me-2"></i>
                            Edit Siswa
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_nama" class="form-label fw-bold">
                                        <i class="fas fa-user text-warning me-1"></i>
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="edit_nama" name="nama" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_nisn" class="form-label fw-bold">
                                        <i class="fas fa-id-card text-warning me-1"></i>
                                        NISN <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="edit_nisn" name="nisn" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_tanggal_lahir" class="form-label fw-bold">
                                        <i class="fas fa-calendar-alt text-warning me-1"></i>
                                        Tanggal Lahir <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" id="edit_tanggal_lahir" name="tanggal_lahir" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_kelas_id" class="form-label fw-bold">
                                        <i class="fas fa-school text-warning me-1"></i>
                                        Kelas <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="edit_kelas_id" name="kelas_id" required>
                                        <option value="" disabled>Pilih Kelas</option>
                                        @foreach ($kelas as $kls)
                                            <option value="{{ $kls->id }}">{{ $kls->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Hapus Siswa -->
    <div class="modal fade" id="deleteSiswaModal" tabindex="-1" aria-labelledby="deleteSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteSiswaModalLabel">
                            <i class="fas fa-trash me-2"></i>
                            Konfirmasi Hapus
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <p>Apakah Anda yakin ingin menghapus siswa <strong id="deleteNama"></strong>?</p>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle me-2"></i>
                            Data yang dihapus tidak dapat dikembalikan!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Edit Siswa: Isi form modal dengan data dari tombol
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-btn');
            const editForm = document.getElementById('editForm');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;

                    // set action form sesuai id
                    editForm.action = `/admin/siswa/${id}`;

                    // isi data ke input
                    document.getElementById('edit_nama').value = this.dataset.nama;
                    document.getElementById('edit_nisn').value = this.dataset.nisn;
                    document.getElementById('edit_tanggal_lahir').value = this.dataset.tanggal_lahir;
                    document.getElementById('edit_kelas_id').value = this.dataset.kelas_id;
                });
            });
        });

        // Delete Siswa: Isi nama dan set action form
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                document.getElementById('deleteNama').textContent = nama;
                document.getElementById('deleteForm').action = `/admin/siswa/${id}`;
            });
        });

        // Auto hide alert
        document.addEventListener("DOMContentLoaded", function() {
            let alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500);
                }, 3000); // 3 detik
            }
        });

        // Form validation
        document.getElementById('createSiswaModal').addEventListener('show.bs.modal', function() {
            // Reset form saat modal dibuka
            this.querySelector('form').reset();
        });

        // Opsional: Gunakan SweetAlert2 untuk tampilan lebih baik
        // Hapus script ini jika tetap pakai modal biasa
        
        // document.querySelectorAll('.delete-btn').forEach(button => {
        //     button.addEventListener('click', function () {
        //         const id = this.getAttribute('data-id');
        //         const nama = this.getAttribute('data-nama');

        //         Swal.fire({
        //             title: 'Yakin hapus?',
        //             text: `Siswa ${nama} akan dihapus permanen.`,
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonColor: '#d33',
        //             cancelButtonColor: '#3085d6',
        //             confirmButtonText: 'Ya, hapus!',
        //             cancelButtonText: 'Batal'
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 fetch(`/admin/siswa/${id}`, {
        //                     method: 'POST',
        //                     headers: {
        //                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        //                         'Content-Type': 'application/json',
        //                     },
        //                     body: JSON.stringify({ _method: 'DELETE' })
        //                 }).then(() => {
        //                     location.reload();
        //                 });
        //             }
        //         });
        //     });
        // });
        
    </script>
@endsection