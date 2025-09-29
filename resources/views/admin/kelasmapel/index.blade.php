@extends('layouts.admin')

@section('title', 'Data Kelas Mata Pelajaran')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Data Kelas Mata Pelajaran</h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKelasMapelModal">
                        <i class="fas fa-plus"></i> Tambah Kelas Mapel
                    </button>
                </div>

                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Table -->
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru Pengajar</th>
                                        <th>Kelas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kelasmapel as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->mapel->nama ?? '-' }}</td>
                                            <td>{{ $item->guru->nama ?? 'Belum Ditentukan' }}</td>
                                            <td>{{ $item->kelas->nama ?? '-' }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <!-- Edit -->
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        onclick="editKelasMapel('{{ $item->id }}','{{ $item->mapel_id }}','{{ $item->guru_id }}','{{ $item->kelas_id }}')"
                                                        data-bs-toggle="modal" data-bs-target="#editKelasMapelModal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <!-- Delete -->
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="deleteKelasMapel('{{ $item->id }}','{{ $item->mapel->nama }}')"
                                                        data-bs-toggle="modal" data-bs-target="#deleteKelasMapelModal">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada data</td>
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="addKelasMapelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.kelasmapel.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kelas Mapel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="mapel_id" class="form-select" required>
                                <option value="">-- Pilih Mapel --</option>
                                @foreach ($mapels as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Guru</label>
                            <select name="guru_id" class="form-select">
                                <option value="">-- Pilih Guru --</option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
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

    <!-- Modal Edit -->
    <div class="modal fade" id="editKelasMapelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kelas Mapel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="mapel_id" id="edit_mapel_id" class="form-select" required>
                                @foreach ($mapels as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Guru</label>
                            <select name="guru_id" id="edit_guru_id" class="form-select">
                                <option value="">-- Pilih Guru --</option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" id="edit_kelas_id" class="form-select" required>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
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

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteKelasMapelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah yakin ingin menghapus <strong id="delete_nama"></strong> dari kelas ini?</p>
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
            function editKelasMapel(id, mapelId, guruId, kelasId) {
                document.getElementById('editForm').action = "{{ url('admin/kelasmapel') }}/" + id;
                document.getElementById('edit_mapel_id').value = mapelId;
                document.getElementById('edit_guru_id').value = guruId;
                document.getElementById('edit_kelas_id').value = kelasId;
            }

            function deleteKelasMapel(id, nama) {
                document.getElementById('deleteForm').action = "{{ url('admin/kelasmapel') }}/" + id;
                document.getElementById('delete_nama').textContent = nama;
            }
        </script>
    @endpush
@endsection
