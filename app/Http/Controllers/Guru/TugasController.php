<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index()
    {
        $tugass = Tugas::with(['matapelajaran', 'kelas'])
            ->where('guru_id', Auth::id())
            ->latest()->paginate(10);

        return view('guru.tugas.index', compact('tugass'));
    }

    public function create()
    {
        $mapels = MataPelajaran::all();
        $kelas  = Kelas::all();
        return view('guru.tugas.create', compact('mapels', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'matapelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id'         => 'nullable|exists:kelas,id',
            'judul'            => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'deadline'         => 'required|date'
        ]);

        $data = $request->only(['matapelajaran_id', 'kelas_id', 'judul', 'deskripsi', 'deadline']);
        $data['guru_id'] = Auth::id();

        Tugas::create($data);

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil dibuat.');
    }

    public function show(Tugas $tugas)
    {
        $this->authorizeAccess($tugas);
        $tugas->load('jawaban.siswa');
        return view('guru.tugas.show', compact('tugas'));
    }

    public function edit(Tugas $tugas)
    {
        $this->authorizeAccess($tugas);
        $mapels = MataPelajaran::all();
        $kelas  = Kelas::all();
        return view('guru.tugas.edit', compact('tugas', 'mapels', 'kelas'));
    }

    public function update(Request $request, Tugas $tugas)
    {
        $this->authorizeAccess($tugas);

        $request->validate([
            'matapelajaran_id' => 'required|exists:mata_pelajarans,id',
            'kelas_id'         => 'nullable|exists:kelas,id',
            'judul'            => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'deadline'         => 'required|date'
        ]);

        $tugas->update($request->only(['matapelajaran_id', 'kelas_id', 'judul', 'deskripsi', 'deadline']));

        return redirect()->route('guru.tugas.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy(Tugas $tugas)
    {


        $this->authorizeAccess($tugas);
        $tugas->delete();
        return redirect()->route('guru.tugas.index')->with('success', 'Tugas dihapus.');
    }

    protected function authorizeAccess(Tugas $tugas)
    {
        if ($tugas->guru_id !== Auth::id()) {
            abort(403, 'Tidak punya akses.');
        }
    }
}
