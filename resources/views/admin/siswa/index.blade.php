@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Siswa</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#createSiswaModal">
                            <i class="fas fa-plus"></i> Tambah Siswa
                        </button>
                    </div>
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
                                            <td>{{ $siswa->nama }}</td>
                                            <td>{{ $siswa->nisn }}</td>
                                            <td>{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}</td>
                                            <td>{{ $siswa->kelas ? $siswa->kelas->nama : '-' }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-warning btn-sm text-white edit-btn"
                                                    data-id="{{ $siswa->id }}" data-nama="{{ $siswa->nama }}"
                                                    data-nisn="{{ $siswa->nisn }}"
                                                    data-tanggal_lahir="{{ $siswa->tanggal_lahir }}"
                                                    data-kelas_id="{{ $siswa->kelas_id }}" data-bs-toggle="modal"
                                                    data-bs-target="#editSiswaModal">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    data-id="{{ $siswa->id }}" data-nama="{{ $siswa->nama }}"
                                                    data-bs-toggle="modal" data-bs-target="#deleteSiswaModal">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data siswa.</td>
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
                            <input type="date" class="form-control" id="edit_tanggal_lahir" name="tanggal_lahir"
                                required>
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
    <div class="modal fade" id="deleteSiswaModal" tabindex="-1" aria-labelledby="deleteSiswaModalLabel"
        aria-hidden="true">
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
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const nisn = this.getAttribute('data-nisn');
                const tanggalLahir = this.getAttribute('data-tanggal_lahir');
                const kelasId = this.getAttribute('data-kelas_id');

                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_nisn').value = nisn;
                document.getElementById('edit_tanggal_lahir').value = tanggalLahir;
                document.getElementById('edit_kelas_id').value = kelasId;

                const form = document.getElementById('editForm');
                form.action = `/admin/siswa/${id}`;
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

        // Opsional: Gunakan SweetAlert2 untuk tampilan lebih baik
        // Hapus script ini jika tetap pakai modal biasa
        /*
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: `Siswa ${nama} akan dihapus permanen.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/admin/siswa/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ _method: 'DELETE' })
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            });
        });
        */
    </script>
@endsection
