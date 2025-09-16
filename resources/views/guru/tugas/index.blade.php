@extends('layouts.admin')

@section('title', 'Manajemen Tugas')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">📚 Manajemen Tugas</h2>
            <!-- Tombol Tambah -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tugasModal"
                onclick="openCreateModal()">+ Tambah Tugas</button>
        </div>

        <!-- Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tabel -->
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Deadline</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tugass as $i => $tugas)
                            <tr>
                                <td class="text-center">{{ $i + $tugass->firstItem() }}</td>
                                <td>{{ $tugas->matapelajaran->nama ?? '-' }}</td>
                                <td>{{ $tugas->kelas->nama ?? '-' }}</td>
                                <td>{{ $tugas->judul }}</td>
                                <td>{{ $tugas->deskripsi }}</td>
                                <td>{{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y H:i') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning text-white"
                                        onclick='openEditModal(@json($tugas))'>Edit</button>
                                    <form action="{{ route('guru.tugas.destroy', $tugas->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin hapus tugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada tugas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $tugass->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit -->
    <div class="modal fade" id="tugasModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="tugasForm" method="POST">
                @csrf
                <input type="hidden" name="_method" value="POST" id="formMethod">




                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalTitle">Tambah Tugas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <select name="matapelajaran_id" class="form-select" required>
                                <option value="">-- Pilih Mapel --</option>
                                @foreach (\App\Models\MataPelajaran::all() as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" class="form-select">
                                <option value="">-- Opsional --</option>
                                @foreach (\App\Models\Kelas::all() as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deadline</label>
                            <input type="datetime-local" name="deadline" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const modal = new bootstrap.Modal(document.getElementById('tugasModal'))
        const form = document.getElementById('tugasForm')
        const methodInput = document.getElementById('formMethod')
        const modalTitle = document.getElementById('modalTitle')

        function openCreateModal() {
            form.reset()
            form.action = "{{ route('guru.tugas.store') }}"
            methodInput.value = "POST"
            modalTitle.innerText = "Tambah Tugas"
            modal.show()
        }

        function openEditModal(tugas) {
            form.reset()
            form.action = "/guru/tugas/" + tugas.id
            methodInput.value = "PUT"
            modalTitle.innerText = "Edit Tugas"

            // isi form dari data tugas
            form.matapelajaran_id.value = tugas.matapelajaran_id
            form.kelas_id.value = tugas.kelas_id ?? ''
            form.judul.value = tugas.judul
            form.deskripsi.value = tugas.deskripsi ?? ''

            if (tugas.deadline) {
                // format deadline → YYYY-MM-DDTHH:mm
                form.deadline.value = tugas.deadline.substring(0, 16)
            }

            modal.show()
        }
    </script>
@endpush
