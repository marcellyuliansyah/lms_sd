@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manajemen Kelas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kelas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Main Card -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-school mr-2"></i>
                        Data Kelas
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createModal">
                            <i class="fas fa-plus mr-1"></i>
                            Tambah Kelas
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="kelasTable" class="table table-bordered table-striped table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="30%">Nama Kelas</th>
                                    <th width="35%">Wali Kelas</th>
                                    <th width="15%" class="text-center">Jumlah Siswa</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelas as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $item->nama }}</strong>
                                        </td>
                                        <td>
                                            @if($item->waliKelas)
                                                <div class="d-flex align-items-center">
                                                    <div class="mr-2">
                                                        <img src="{{ $item->waliKelas->avatar ?? asset('lte/dist/img/user2-160x160.jpg') }}" 
                                                             alt="Avatar" class="img-circle" width="30" height="30">
                                                    </div>
                                                    <div>
                                                        <strong>{{ $item->waliKelas->nama }}</strong><br>
                                                        <small class="text-muted">{{ $item->waliKelas->nip ?? 'NIP belum diatur' }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">
                                                    <i class="fas fa-user-times mr-1"></i>
                                                    Belum ada wali kelas
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info badge-lg">
                                                {{ $item->siswa_count ?? 0 }} siswa
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-warning btn-sm edit-btn" 
                                                        data-id="{{ $item->id }}"
                                                        data-nama="{{ $item->nama }}"
                                                        data-wali="{{ $item->wali_kelas_id }}"
                                                        data-toggle="modal" data-target="#editModal"
                                                        title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                                        data-id="{{ $item->id }}"
                                                        data-nama="{{ $item->nama }}"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i><br>
                                                <h5>Belum ada data kelas</h5>
                                                <p>Klik tombol "Tambah Kelas" untuk menambah data kelas baru.</p>
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
    </section>
</div>

<!-- Modal Create -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.kelas.store') }}" method="POST" id="createForm">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createModalLabel">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Kelas Baru
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_nama" class="form-label">
                                    <i class="fas fa-school mr-1"></i>
                                    Nama Kelas <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama') is-invalid @enderror" 
                                       id="create_nama" 
                                       name="nama" 
                                       value="{{ old('nama') }}"
                                       placeholder="Contoh: X IPA 1, XI IPS 2"
                                       required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_wali_kelas_id" class="form-label">
                                    <i class="fas fa-chalkboard-teacher mr-1"></i>
                                    Wali Kelas
                                </label>
                                <select class="form-control select2 @error('wali_kelas_id') is-invalid @enderror" 
                                        id="create_wali_kelas_id" 
                                        name="wali_kelas_id">
                                    <option value="">-- Pilih Wali Kelas --</option>
                                    @foreach($gurus as $guru)
                                        <option value="{{ $guru->id }}" {{ old('wali_kelas_id') == $guru->id ? 'selected' : '' }}>
                                            {{ $guru->nama }} {{ $guru->nip ? '(' . $guru->nip . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('wali_kelas_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Wali kelas bersifat opsional, bisa diatur nanti.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Kelas
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nama" class="form-label">
                                    <i class="fas fa-school mr-1"></i>
                                    Nama Kelas <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="edit_nama" 
                                       name="nama" 
                                       placeholder="Contoh: X IPA 1, XI IPS 2"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_wali_kelas_id" class="form-label">
                                    <i class="fas fa-chalkboard-teacher mr-1"></i>
                                    Wali Kelas
                                </label>
                                <select class="form-control select2" 
                                        id="edit_wali_kelas_id" 
                                        name="wali_kelas_id">
                                    <option value="">-- Pilih Wali Kelas --</option>
                                    @foreach($gurus as $guru)
                                        <option value="{{ $guru->id }}">
                                            {{ $guru->nama }} {{ $guru->nip ? '(' . $guru->nip . ')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Wali kelas bersifat opsional, bisa diatur nanti.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i>
                        Update Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete Confirmation -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                <h5>Apakah Anda yakin ingin menghapus kelas ini?</h5>
                <p class="mb-0">Kelas: <strong id="delete_nama_kelas"></strong></p>
                <small class="text-muted">Data yang sudah dihapus tidak dapat dikembalikan!</small>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Batal
                </button>
                <form method="POST" id="deleteForm" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i>
                        Ya, Hapus!
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{ asset('lte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<style>
.table th {
    vertical-align: middle;
    font-weight: 600;
}
.table td {
    vertical-align: middle;
}
.btn-group .btn {
    margin: 0 1px;
}
.modal-header {
    border-bottom: 2px solid rgba(0,0,0,0.1);
}
.form-label {
    font-weight: 600;
    color: #495057;
}
.select2-container .select2-selection--single {
    height: 38px;
    border: 1px solid #ced4da;
}
.select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
}
</style>
@endpush

@push('scripts')
<!-- DataTables JS -->
<script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- Select2 JS -->
<script src="{{ asset('lte/plugins/select2/js/select2.full.min.js') }}"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#kelasTable').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        columnDefs: [
            { orderable: false, targets: [4] }
        ],
        order: [[1, 'asc']]
    });

    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });

    // Edit Modal Handler
    $('.edit-btn').click(function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        const wali = $(this).data('wali');
        
        $('#edit_nama').val(nama);
        $('#edit_wali_kelas_id').val(wali).trigger('change');
        $('#editForm').attr('action', `/admin/kelas/${id}`);
    });

    // Delete Modal Handler
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        const nama = $(this).data('nama');
        
        $('#delete_nama_kelas').text(nama);
        $('#deleteForm').attr('action', `/admin/kelas/${id}`);
        $('#deleteModal').modal('show');
    });

    // Reset form when modal is closed
    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('.invalid-feedback').remove();
        $('.select2').val(null).trigger('change');
    });

    // Auto-hide alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
@endpush