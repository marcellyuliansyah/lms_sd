<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataSiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with('kelas')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        return view('admin.siswa.index', compact('siswas', 'kelas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|unique:siswas,nisn',
            'tanggal_lahir' => 'required|date',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $email = strtolower($validated['nisn']) . '@sditompokersan.sch.id';

        // Buat atau ambil user, password default SDIlmj2025
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $validated['nama'],
                'password' => Hash::make('SDIlmj2025'),
                'role' => 'siswa',
            ]
        );

        $validated['user_id'] = $user->id;
        Siswa::create($validated);

        return redirect()->route('admin.siswa.index')
            ->with('success', "Siswa dan akun berhasil dibuat. Email: $email | Password: SDIlmj2025");
    }

    public function edit(Siswa $siswa)
    {
        // Jika request AJAX → return JSON
        if (request()->ajax()) {
            return response()->json($siswa);
        }

        // Jika bukan AJAX → tampilkan view edit
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }



    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|unique:siswas,nisn,' . $siswa->id,
            'tanggal_lahir' => 'required|date',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa->update($validated);

        return redirect()->route('admin.siswa.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->user) {
            $siswa->user->delete(); // hapus akun siswa
        }

        $siswa->delete(); // hapus data siswa
        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa dan akun berhasil dihapus.');
    }
}
