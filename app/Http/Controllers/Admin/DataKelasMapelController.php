<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasMapel;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Http\Request;

class DataKelasMapelController extends Controller
{
    public function index()
    {
        $kelasmapel = KelasMapel::with(['kelas', 'mapel', 'guru'])->get();
        $mapels = Mapel::all();
        $gurus = Guru::all();
        $kelas = Kelas::all();

        return view('admin.kelasmapel.index', compact('kelasmapel', 'mapels', 'gurus', 'kelas'));
    }


    public function create()
    {
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $gurus = Guru::all();
        return view('admin.kelasmapel.create', compact('kelas', 'mapels', 'gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id'  => 'nullable|exists:gurus,id',
        ]);

        KelasMapel::create($request->all());
        return redirect()->route('admin.kelasmapel.index')->with('success', 'Data kelas-mapel berhasil ditambahkan');
    }

    public function edit(KelasMapel $kelasmapel)
    {
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $gurus = Guru::all();
        return view('admin.kelasmapel.edit', compact('kelasmapel', 'kelas', 'mapels', 'gurus'));
    }

    public function update(Request $request, KelasMapel $kelasmapel)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id'  => 'nullable|exists:gurus,id',
        ]);

        $kelasmapel->update($request->all());
        return redirect()->route('admin.kelasmapel.index')->with('success', 'Data kelas-mapel berhasil diperbarui');
    }

    public function destroy(KelasMapel $kelasmapel)
    {
        $kelasmapel->delete();
        return redirect()->route('admin.kelasmapel.index')->with('success', 'Data kelas-mapel berhasil dihapus');
    }
}
