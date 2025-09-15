<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::with(['guru', 'kelas'])->get();
        $gurus = Guru::orderBy('nama')->get(); // Tambahkan ini
        $kelas = Kelas::orderBy('nama')->get(); // Tambahkan ini
        return view('admin.mapel.index', compact('mapel', 'gurus', 'kelas'));
    }

    public function create()
    {
        $gurus = Guru::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama')->get();
        return view('admin.mapel.create', compact('gurus', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        MataPelajaran::create($request->all());

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    public function edit(MataPelajaran $mapel)
    {
        $gurus = Guru::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama')->get();
        return view('admin.mapel.edit', compact('mapel', 'gurus', 'kelas'));
    }

    public function update(Request $request, MataPelajaran $mapel)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'guru_id' => 'required|exists:gurus,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $mapel->update($request->all());

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui');
    }

    public function destroy(MataPelajaran $mapel)
    {
        $mapel->delete();
        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus');
    }
}