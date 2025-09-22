<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.dashboard');
    }

    public function store(Request $request)
    {
        Siswa::create($request->all());

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function update(Request $request, Siswa $siswa)
    {
        $siswa->update($request->all());

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus!');
    }
}
