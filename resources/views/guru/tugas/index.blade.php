@extends('layouts.admin')

@section('title', 'Manajemen Tugas')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">📚 Manajemen Tugas</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tugasModal"
                onclick="openCreateModal()">+ Tambah Tugas</button>
        </div>

        @if (session('success'))
            <div id="alertBox" class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div id="alertBox" class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Daftar Tugas</h5>
                <small class="text-muted">Total: {{ $tugas->count() }} tugas</small>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Mata Pelajaran</th>
                            <th width="15%">Kelas</th>
                            <th width="20%">Judul</th>
                            <th width="25%">Deskripsi</th>
                            <th width="15%">Deadline</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tugas as $i => $t)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        {{ $t->kelasMapel->mapel->nama ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $t->kelasMapel->kelas->nama ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $t->judul }}</strong>
                                </td>
                                <td>
                                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $t->deskripsi ?: 'Tidak ada deskripsi' }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($t->deadline)
                                        <span class="badge {{ \Carbon\Carbon::parse($t->deadline)->isPast() ? 'bg-danger' : 'bg-success' }}">
                                            {{ \Carbon\Carbon::parse($t->deadline)->format('d M Y') }}
                                            <br>
                                            {{ \Carbon\Carbon::parse($t->deadline)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-warning text-white"
                                            onclick='openEditModal(@json($t))'
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('guru.tugas.destroy', $t->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin hapus tugas \'{{ $t->judul }}\'?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <h5>Belum ada tugas</h5>
                                        <p>Klik tombol "Tambah Tugas" untuk membuat tugas baru</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kelas & Mata Pelajaran <span class="text-danger">*</span></label>
                            <select name="kelas_mapel_id" class="form-select" required id="kelasMapelSelect">
                                <option value="">-- Pilih Kelas & Mata Pelajaran --</option>
                                @foreach ($kelasMapel as $km)
                                    <option value="{{ $km->id }}">
                                        {{ $km->kelas->nama ?? 'N/A' }} - {{ $km->mapel->nama ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" required id="judulInput" 
                                placeholder="Masukkan judul tugas">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4" id="deskripsiInput"
                                placeholder="Masukkan deskripsi tugas (opsional)"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deadline</label>
                            <input type="datetime-local" name="deadline" class="form-control" id="deadlineInput">
                            <small class="text-muted">Kosongkan jika tidak ada deadline</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="submitBtn">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
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
        const submitBtn = document.getElementById('submitBtn')

        function openCreateModal() {
            form.reset()
            form.action = "{{ route('guru.tugas.store') }}"
            methodInput.value = "POST"
            modalTitle.innerHTML = '<i class="fas fa-plus"></i> Tambah Tugas'
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Simpan'
            modal.show()
        }

        function openEditModal(tugas) {
            form.reset()
            form.action = "{{ url('guru/tugas') }}/" + tugas.id
            methodInput.value = "PUT"
            modalTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Tugas'
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Update'

            // Set values
            document.getElementById('kelasMapelSelect').value = tugas.kelas_mapel_id
            document.getElementById('judulInput').value = tugas.judul
            document.getElementById('deskripsiInput').value = tugas.deskripsi ?? ''
            
            if (tugas.deadline) {
                // Format datetime untuk input datetime-local
                const deadline = new Date(tugas.deadline)
                const formattedDeadline = deadline.toISOString().slice(0, 16)
                document.getElementById('deadlineInput').value = formattedDeadline
            }

            modal.show()
        }

        // Auto hide alerts
        document.addEventListener("DOMContentLoaded", function() {
            let alertBox = document.getElementById("alertBox");
            if (alertBox) {
                setTimeout(() => {
                    let alert = new bootstrap.Alert(alertBox);
                    alert.close();
                }, 3000);
            }
        });

        // Form validation
        form.addEventListener('submit', function(e) {
            const judul = document.getElementById('judulInput').value.trim()
            const kelasMapel = document.getElementById('kelasMapelSelect').value
            
            if (!judul || !kelasMapel) {
                e.preventDefault()
                alert('Harap lengkapi field yang wajib diisi!')
                return false
            }
            
            submitBtn.disabled = true
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...'
        })
    </script>
@endpush