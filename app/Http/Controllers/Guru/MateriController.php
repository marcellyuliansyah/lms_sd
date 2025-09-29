<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\KelasMapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function index()
    {
        $materi = Materi::where('guru_id', Auth::id())->get();
        return view('guru.materi.index', compact('materi'));
    }

    public function create()
    {
        $kelasMapel = KelasMapel::where('guru_id', Auth::id())->get();
        return view('guru.materi.create', compact('kelasMapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_mapel_id' => 'required|exists:kelas_mapel,id',
            'judul' => 'required|string|max:255',
            'file' => 'nullable|file'
        ]);

        $data = $request->all();
        $data['guru_id'] = Auth::id();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('materi');
        }

        Materi::create($data);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil ditambahkan');
    }
}
