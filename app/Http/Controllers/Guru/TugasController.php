<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Tugas;
use App\Models\KelasMapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index()
    {
        // Ambil guru berdasarkan user yang login
        $guru = Guru::where('user_id', Auth::id())->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }

        // Ambil tugas berdasarkan guru_id dengan relasi
        $tugas = Tugas::with(['kelasMapel.kelas', 'kelasMapel.mapel'])
            ->where('guru_id', $guru->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil kelas mapel untuk dropdown
        $kelasMapel = KelasMapel::with(['kelas', 'mapel'])
            ->where('guru_id', $guru->id)
            ->get();

        return view('guru.tugas.index', compact('tugas', 'kelasMapel'));
    }

    public function create()
    {
        $guru = Guru::where('user_id', Auth::id())->first();

        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }

        $kelasMapel = KelasMapel::with(['kelas', 'mapel'])
            ->where('guru_id', $guru->id)
            ->get();

        return view('guru.tugas.create', compact('kelasMapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_mapel_id' => 'required|exists:kelas_mapel,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:2048',
        ]);

        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $kelasMapel = KelasMapel::where('id', $request->kelas_mapel_id)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('tugas', 'public');
        }


        Tugas::create([
            'kelas_mapel_id' => $request->kelas_mapel_id,
            'guru_id'        => $guru->id,
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'deadline'       => $request->deadline,
            'file_path'      => $filePath,
        ]);

        return redirect()->route('guru.tugas.index')
            ->with('success', 'Tugas berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas_mapel_id' => 'required|exists:kelas_mapel,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'deadline' => 'nullable|date'
        ]);

        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $tugas = Tugas::where('id', $id)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        // Pastikan kelas_mapel_id milik guru yang login
        $kelasMapel = KelasMapel::where('id', $request->kelas_mapel_id)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $tugas->update([
            'kelas_mapel_id' => $request->kelas_mapel_id,
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'deadline'       => $request->deadline,
        ]);

        return redirect()->route('guru.tugas.index')
            ->with('success', 'Tugas berhasil diupdate');
    }

    public function destroy($id)
    {
        $guru = Guru::where('user_id', Auth::id())->firstOrFail();

        $tugas = Tugas::where('id', $id)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $tugas->delete();

        return redirect()->route('guru.tugas.index')
            ->with('success', 'Tugas berhasil dihapus');
    }
}
