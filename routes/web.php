<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DataGuruController;
use App\Http\Controllers\Admin\DataKelasController;
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\Guru\KelasSayaController;
use App\Http\Controllers\Siswa\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// === AUTH ===
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login.form');

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === DASHBOARD ===
Route::middleware(['auth', 'chaceLogout'])->group(function () {

    // ADMIN
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::post('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::resource('guru', DataGuruController::class);
        Route::resource('siswa', DataSiswaController::class);
        Route::resource('kelas', DataKelasController::class);
        Route::resource('mapel', MataPelajaranController::class);
    });

    // GURU
    Route::prefix('guru')->name('guru.')->middleware('role:guru')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'index'])->name('dashboard');
        Route::resource('kelas', KelasSayaController::class);
    });

    // SISWA
    Route::prefix('siswa')->name('siswa.')->middleware('role:siswa')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'index'])->name('dashboard');
    });
});
