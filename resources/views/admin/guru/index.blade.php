@extends('layouts.admin')

@section('title', 'Data Guru')

@section('content')
<div class="container-fluid">
    {{-- Alert Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="fas fa-chalkboard-teacher mr-2"></i> Data Guru
            </h3>
            <a href="{{ route('admin.guru.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle"></i> Tambah Guru
            </a>
        </div>

        <div class="card-body">
            {{-- Search Form --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.guru.index') }}" class="d-flex">
                        <div class="input-group">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Cari guru (nama, NIP, email, telepon)..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i> Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    @if(request('search'))
                        <small class="text-muted">
                            Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                            ({{ $gurus->total() }} data ditemukan)
                        </small>
                    @else
                        <small class="text-muted">
                            Total: {{ $gurus->total() }} guru
                        </small>
                    @endif
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gurus as $index => $guru)
                            <tr>
                                <td>{{ $loop->iteration + ($gurus->currentPage()-1)*$gurus->perPage() }}</td>
                                <td>
                                    @if(request('search'))
                                        {!! str_ireplace(request('search'), '<mark>'.request('search').'</mark>', $guru->nama) !!}
                                    @else
                                        {{ $guru->nama }}
                                    @endif
                                </td>
                                <td>
                                    @if(request('search'))
                                        {!! str_ireplace(request('search'), '<mark>'.request('search').'</mark>', $guru->nip) !!}
                                    @else
                                        {{ $guru->nip }}
                                    @endif
                                </td>
                                <td>
                                    @if(request('search'))
                                        {!! str_ireplace(request('search'), '<mark>'.request('search').'</mark>', $guru->email) !!}
                                    @else
                                        {{ $guru->email }}
                                    @endif
                                </td>
                                <td>
                                    @if(request('search') && $guru->telepon)
                                        {!! str_ireplace(request('search'), '<mark>'.request('search').'</mark>', $guru->telepon ?? '-') !!}
                                    @else
                                        {{ $guru->telepon ?? '-' }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus guru ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    @if(request('search'))
                                        <i class="fas fa-search fa-2x mb-2 text-secondary"></i><br>
                                        Tidak ada data guru yang sesuai dengan pencarian "<strong>{{ request('search') }}</strong>"
                                        <br>
                                        <a href="{{ route('admin.guru.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-arrow-left"></i> Kembali ke semua data
                                        </a>
                                    @else
                                        <i class="fas fa-users fa-2x mb-2 text-secondary"></i><br>
                                        Belum ada data guru
                                        <br>
                                        <a href="{{ route('admin.guru.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="fas fa-plus-circle"></i> Tambah Guru Pertama
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($gurus->hasPages())
                <div class="mt-3">
                    {{ $gurus->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Highlighting search results */
mark {
    background-color: #fff3cd;
    padding: 5px 5px;
    border-radius: 2px;
    font-weight: 500;
}

/* Search form enhancements */
.input-group .btn {
    border-color: #dee2e6;
}

.input-group .btn:hover {
    background-color: #dddddddd;
}

/* Empty state styling */
.table tbody tr td {
    vertical-align: middle;
}

/* Responsive search */
@media (max-width: 768px) {
    .card-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .input-group {
        margin-bottom: 1rem;
    }
    
    .col-md-6.text-end {
        text-align: center !important;
    }
}
</style>

{{-- JavaScript untuk enhance search experience --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto focus pada search input jika ada parameter search
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput && searchInput.value) {
        searchInput.focus();
        searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
    }
    
    // Clear search dengan keyboard shortcut (Ctrl + K atau Cmd + K)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
            searchInput.select();
        }
        
        // ESC untuk clear search
        if (e.key === 'Escape' && document.activeElement === searchInput) {
            if (searchInput.value) {
                window.location.href = '{{ route("admin.guru.index") }}';
            }
        }
    });
    
    // Search on enter
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            this.closest('form').submit();
        }
    });
});
</script>
@endsection