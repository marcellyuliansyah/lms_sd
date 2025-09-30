<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasSiswaController extends Controller
{

    public function index()
    {
        $siswa = Siswa::where('user_id', Auth::id())->firstOrFail();

        // Ambil semua tugas berdasarkan kelas siswa
        $tugas = Tugas::whereHas('kelasMapel', function ($q) use ($siswa) {
            $q->where('kelas_id', $siswa->kelas_id);
        })->with(['kelasMapel.kelas', 'kelasMapel.mapel', 'guru'])->latest()->get();

        return view('siswa.tugas.index', compact('tugas'));
    }
}
