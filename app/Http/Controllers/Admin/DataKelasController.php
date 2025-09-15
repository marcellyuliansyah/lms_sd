<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class DataKelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('waliKelas')->withCount('siswas')->get();
        $gurus = Guru::all();
        return view('admin.kelas.index', compact('kelas', 'gurus'));
    }

    public function create()
    {
        $gurus = Guru::all(); // untuk dropdown wali kelas
        return view('admin.kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kelas,nama',
            'wali_kelas_id' => 'nullable|exists:gurus,id',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(Kelas $kela)
    {
        $kela->load('waliKelas', 'siswas'); // perbaikan di sini
        return view('admin.kelas.show', compact('kela'));
    }


    public function edit(Kelas $kela) // gunakan $kela karena route model binding default pakai nama singular
    {
        $gurus = Guru::all();
        return view('admin.kelas.edit', compact('kela', 'gurus'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kelas,nama,' . $kela->id,
            'wali_kelas_id' => 'nullable|exists:gurus,id',
        ]);

        $kela->update($request->all());

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        if ($kela->siswas()->count() > 0) { // perbaikan di sini
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa.');
        }

        $kela->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
