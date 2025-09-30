@extends('layouts.admin')

@section('title', 'Buat akun')

@section('content')

    <!-- Form Create Admin / Guru -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Buat Akun Baru (Admin / Guru)</h5>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.users.create') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Role</label>
                            <select name="role" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="guru">Guru</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Buat Akun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
