<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Mapel;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Auth;

class UjianController extends Controller
{
    public function index()
    {
        $ujians = Ujian::where('guru_id', Auth::id())->with('mapel')->get();
        $mapels = MataPelajaran::all(); // ambil semua mapel
        return view('guru.soalujian.index', compact('ujians', 'mapels'));
    }


    public function create()
    {
        $mapels = MataPelajaran::all();
        return view('guru.ujian.create', compact('mapels'));
    }

    public function store(Request $request)
    {
        $ujian = Ujian::create([
            'mapel_id' => $request->mapel_id,
            'guru_id' => Auth::id(),
            'judul' => $request->judul,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai
        ]);

        return redirect()->route('guru.ujian.index', $ujian->id)->with('success', 'Ujian berhasil dibuat. Tambahkan soal!');
    }

    public function edit($id)
    {
        $ujian = Ujian::with('soal')->findOrFail($id);
        return view('guru.ujian.edit', compact('ujian'));
    }

    public function update(Request $request, $id)
    {
        $ujian = Ujian::findOrFail($id);
        $ujian->update($request->only(['judul', 'waktu_mulai', 'waktu_selesai']));
        return redirect()->route('guru.ujian.index')->with('success', 'Ujian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $ujian = Ujian::findOrFail($id);
        $ujian->delete();
        return redirect()->route('guru.ujian.index')->with('success', 'Ujian berhasil dihapus.');
    }
}
