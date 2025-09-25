@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{-- Notifikasi sukses --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses!</strong> {{ session('success') }}
                    </div>
                @endif

                <div class="bg-gradient-navy text-white rounded-3 p-2 mb-3 shadow">
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <h1 class="h3 card-title mb-0">
                                <i class="fas fa-users me-2"></i>Kelola Data Siswa
                            </h1>
                            <button type="button" class="btn btn-primary btn-sm mt-2 mt-md-0" data-bs-toggle="modal"
                                data-bs-target="#createSiswaModal">
                                <i class="fas fa-plus-circle"></i> Tambah Siswa
                            </button>
                    </div>
                </div>

                {{-- Form Pencarian --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="{{ route('admin.siswa.index') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Pencarian</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           value="{{ request('search') }}" 
                                           placeholder="Cari berdasarkan nama, NISN, atau kelas...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="kelas_filter" class="form-label">Filter Kelas</label>
                                <select class="form-select" id="kelas_filter" name="kelas_filter">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelas as $kls)
                                        <option value="{{ $kls->id }}" {{ request('kelas_filter') == $kls->id ? 'selected' : '' }}>
                                            {{ $kls->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label d-block">&nbsp;</label>
                                <div class="btn-group" role="group">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Hasil Pencarian --}}
                @if(request('search') || request('kelas_filter'))
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Hasil Pencarian:</strong> 
                        Menampilkan {{ $siswas->count() }} siswa
                        @if(request('search'))
                            untuk pencarian "<strong>{{ request('search') }}</strong>"
                        @endif
                        @if(request('kelas_filter'))
                            @php
                                $kelasNama = $kelas->where('id', request('kelas_filter'))->first();
                            @endphp
                            di kelas "<strong>{{ $kelasNama ? $kelasNama->nama : 'Tidak Diketahui' }}</strong>"
                        @endif
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>NISN</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Kelas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($siswas as $siswa)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{-- Highlight search results --}}
                                                @if(request('search'))
                                                    {!! str_replace(request('search'), '<mark class="bg-warning">' . request('search') . '</mark>', $siswa->nama) !!}
                                                @else
                                                    {{ $siswa->nama }}
                                                @endif
                                            </td>
                                            <td>
                                                @if(request('search'))
                                                    {!! str_replace(request('search'), '<mark class="bg-warning">' . request('search') . '</mark>', $siswa->nisn) !!}
                                                @else
                                                    {{ $siswa->nisn }}
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}</td>
                                            <td>
                                                @if(request('search') && $siswa->kelas)
                                                    {!! str_replace(request('search'), '<mark class="bg-warning">' . request('search') . '</mark>', $siswa->kelas->nama) !!}
                                                @else
                                                    {{ $siswa->kelas ? $siswa->kelas->nama : '-' }}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <!-- Tombol Edit -->
                                                <button type="button" class="btn btn-warning btn-sm text-white edit-btn"
                                                    data-id="{{ $siswa->id }}" data-nama="{{ $siswa->nama }}"
                                                    data-nisn="{{ $siswa->nisn }}"
                                                    data-tanggal_lahir="{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') }}"
                                                    data-kelas_id="{{ $siswa->kelas_id }}" data-bs-toggle="modal"
                                                    data-bs-target="#editSiswaModal">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>

                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Yakin hapus siswa {{ $siswa->nama }}?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                @if(request('search') || request('kelas_filter'))
                                                    <div class="text-muted">
                                                        <i class="fas fa-search fa-2x mb-2"></i><br>
                                                        Tidak ditemukan siswa yang sesuai dengan kriteria pencarian.
                                                        <br><br>
                                                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-arrow-left"></i> Kembali ke semua data
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="text-muted">
                                                        <i class="fas fa-users fa-2x mb-2"></i><br>
                                                        Belum ada data siswa.
                                                        <br><br>
                                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                            data-target="#createSiswaModal">
                                                            <i class="fas fa-plus"></i> Tambah Siswa Pertama
                                                        </button>
                                                    </div>
                                                @endif
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

    <!-- Modal Tambah Siswa -->
    <div class="modal fade" id="createSiswaModal" tabindex="-1" aria-labelledby="createSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.siswa.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSiswaModalLabel">Tambah Siswa Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas_id" name="kelas_id" required>
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach ($kelas as $kls)
                                    <option value="{{ $kls->id }}">{{ $kls->nama }}</option>
                                @endforeach
                            </select>
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

    <!-- Modal Edit Siswa -->
    <div class="modal fade" id="editSiswaModal" tabindex="-1" aria-labelledby="editSiswaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSiswaModalLabel">Edit Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="edit_nisn" name="nisn" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="edit_tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_kelas_id" class="form-label">Kelas</label>
                            <select class="form-select" id="edit_kelas_id" name="kelas_id" required>
                                <option value="" disabled>Pilih Kelas</option>
                                @foreach ($kelas as $kls)
                                    <option value="{{ $kls->id }}">{{ $kls->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Update</button>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteSiswaModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus siswa <strong id="deleteNama"></strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Edit Siswa: Isi form modal dengan data dari tombol
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-btn');
            const editForm = document.getElementById('editForm');

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;

                    // set action form sesuai id
                    editForm.action = `/admin/siswa/${id}`;

                    // isi data ke input
                    document.getElementById('edit_nama').value = this.dataset.nama;
                    document.getElementById('edit_nisn').value = this.dataset.nisn;
                    document.getElementById('edit_tanggal_lahir').value = this.dataset
                        .tanggal_lahir;
                    document.getElementById('edit_kelas_id').value = this.dataset.kelas_id;
                });
            });
        });

        // Delete Siswa: Isi nama dan set action form
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                document.getElementById('deleteNama').textContent = nama;
                document.getElementById('deleteForm').action = `/admin/siswa/${id}`;
            });
        });

        // Auto dismiss alert
        document.addEventListener("DOMContentLoaded", function () {
            let alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.classList.remove('show');
                    alert.classList.add('fade');
                    setTimeout(() => alert.remove(), 500); // hapus dari DOM setelah animasi
                }, 2000); // 2 detik
            }
        });

        // Search on Enter key
        document.getElementById('search').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.closest('form').submit();
            }
        });

        // Auto submit when filter kelas changed
        document.getElementById('kelas_filter').addEventListener('change', function() {
            this.closest('form').submit();
        });
    </script>
@endsection