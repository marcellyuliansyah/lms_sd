<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BuatAkunController;
use App\Http\Controllers\Admin\DataGuruController;
use App\Http\Controllers\Admin\DataKelasController;
use App\Http\Controllers\Admin\DataSiswaController;
use App\Http\Controllers\Admin\DataKelasMapelController;
use App\Http\Controllers\Admin\DataMapelController;
use App\Http\Controllers\Guru\GuruController;
use App\Http\Controllers\Guru\KelasSayaController;
use App\Http\Controllers\Guru\MateriController;

use App\Http\Controllers\Guru\TugasController;

use App\Http\Controllers\Siswa\SiswaController;
use App\Http\Controllers\Siswa\TugasSiswaController;

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
        Route::resource('buatakun', BuatAkunController::class);
        Route::resource('guru', DataGuruController::class);
        Route::resource('siswa', DataSiswaController::class);
        Route::resource('kelas', DataKelasController::class);
        Route::resource('mapel', DataMapelController::class);
        Route::resource('kelasmapel', DataKelasMapelController::class);
    });

    // GURU
    Route::prefix('guru')->name('guru.')->middleware('role:guru')->group(function () {
        Route::get('/dashboard', [GuruController::class, 'index'])->name('dashboard');
        Route::resource('kelas', KelasSayaController::class);
        Route::resource('materi', MateriController::class);
        Route::resource('tugas', TugasController::class)->parameters([
            'tugas' => 'tugas'
        ]);
    });

    // SISWA
    Route::prefix('siswa')->name('siswa.')->middleware('role:siswa')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'index'])->name('dashboard');
        Route::resource('tugas', TugasSiswaController::class);
    });
});
