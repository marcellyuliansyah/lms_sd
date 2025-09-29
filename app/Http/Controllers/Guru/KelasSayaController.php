<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\KelasMapel;
use Illuminate\Support\Facades\Auth;

class KelasSayaController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        if (!$guru) {
            abort(403, 'Akun Anda belum terdaftar sebagai guru.');
        }

        $kelasSaya = KelasMapel::with(['kelas','mapel'])
            ->where('guru_id', $guru->id)
            ->get();

        return view('guru.kelas.index', compact('kelasSaya'));
    }

    public function show(KelasMapel $kela)
    {
        $guru = Auth::user()->guru;
        abort_if($kela->guru_id !== $guru->id, 403);

        return view('guru.kelas.show', compact('kela'));
    }
}
