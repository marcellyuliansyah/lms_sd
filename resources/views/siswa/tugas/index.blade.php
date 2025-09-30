@extends('layouts.admin')

@section('title', 'Tugas Saya')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold text-primary mb-4">
        <i class="fas fa-tasks"></i> Daftar Tugas
    </h2>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">Mapel</th>
                        <th width="15%">Kelas</th>
                        <th width="20%">Judul</th>
                        <th width="25%">Deskripsi</th>
                        <th width="15%">Deadline</th>
                        <th width="15%">File</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugas as $t)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><span class="badge bg-info">{{ $t->kelasMapel->mapel->nama }}</span></td>
                            <td><span class="badge bg-secondary">{{ $t->kelasMapel->kelas->nama }}</span></td>
                            <td><strong>{{ $t->judul }}</strong></td>
                            <td>{{ $t->deskripsi ?? '-' }}</td>
                            <td class="text-center">
                                @if($t->deadline)
                                    <span class="badge {{ \Carbon\Carbon::parse($t->deadline)->isPast() ? 'bg-danger' : 'bg-success' }}">
                                        {{ \Carbon\Carbon::parse($t->deadline)->format('d M Y H:i') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($t->file_path)
                                    <a href="{{ asset('storage/'.$t->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <h5>Belum ada tugas untuk kelas kamu</h5>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
