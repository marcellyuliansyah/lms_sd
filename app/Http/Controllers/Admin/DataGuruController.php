<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class DataGuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::with(['mataPelajaran', 'kelas'])->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:gurus,nip',
            'email' => 'required|email|unique:gurus,email',
            'telepon' => 'nullable|string|max:20',
        ]);

        Guru::create($request->all());

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50|unique:gurus,nip,' . $guru->id,
            'email' => 'required|email|unique:gurus,email,' . $guru->id,
            'telepon' => 'nullable|string|max:20',
        ]);

        $guru->update($request->all());

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}
