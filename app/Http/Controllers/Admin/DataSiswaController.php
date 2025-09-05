<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class DataSiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with('kelas')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        return view('admin.siswa.index', compact('siswas', 'kelas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|unique:siswas,nisn',
            'tanggal_lahir' => 'required|date',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        Siswa::create($request->validated());

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        // Jika request AJAX → return JSON
        if (request()->ajax()) {
            return response()->json($siswa);
        }

        // Jika bukan AJAX → tampilkan view edit
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }



    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|unique:siswas,nisn,' . $siswa->id,
            'tanggal_lahir' => 'required|date',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa->update($request->validated());

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
