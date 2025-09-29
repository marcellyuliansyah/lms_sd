@extends('layouts.admin')

@section('title', 'Edit Ujian')
    <div class="container py-4">
        <div class="card">
            <div class="card-header">Edit Ujian</div>
            <div class="card-body">
                <form action="{{ route('admin.ujians.update', $ujian) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="mapel_id" class="form-select" required>
                            @foreach ($mapels as $mapel)
                                <option value="{{ $mapel->id }}" @if ($mapel->id == $ujian->mapel_id) selected @endif>
                                    {{ $mapel->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Guru</label>
                        <select name="guru_id" class="form-select" required>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}" @if ($guru->id == $ujian->guru_id) selected @endif>
                                    {{ $guru->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" value="{{ $ujian->judul }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Waktu Mulai</label>
                        <input type="datetime-local" name="waktu_mulai"
                            value="{{ $ujian->waktu_mulai->format('Y-m-d\TH:i') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Waktu Selesai</label>
                        <input type="datetime-local" name="waktu_selesai"
                            value="{{ $ujian->waktu_selesai->format('Y-m-d\TH:i') }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="draft" @if ($ujian->status == 'draft') selected @endif>Draft</option>
                            <option value="published" @if ($ujian->status == 'published') selected @endif>Published</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.ujians.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
