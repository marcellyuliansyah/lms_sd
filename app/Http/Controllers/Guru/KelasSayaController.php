<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class KelasSayaController extends Controller
{
    public function index()
    {
        $guru = Auth::user();

        // Ambil semua kelas dengan relasi yang dibutuhkan
        $kelas = Kelas::with(['waliKelas', 'siswas', 'mataPelajarans'])->get();

        return view('guru.kelas.index', compact('kelas', 'guru'));
    }

    public function show($id)
    {
        $kelas = Kelas::with(['waliKelas', 'mataPelajarans', 'siswas'])->findOrFail($id);
        return view('guru.kelas.show', compact('kelas'));
    }
}
