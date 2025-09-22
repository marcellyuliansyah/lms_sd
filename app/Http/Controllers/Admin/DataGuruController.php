<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;

class DataGuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query();
        
        // Jika ada parameter search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nip', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('telepon', 'LIKE', "%{$search}%");
            });
        }
        
        $gurus = $query->latest()->paginate(10);
        
        // Maintain search parameter in pagination links
        if ($request->has('search')) {
            $gurus->appends(['search' => $request->search]);
        }
        
        return view('admin.guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'nip'     => 'required|string|max:30|unique:gurus,nip',
            'email'   => 'required|email|unique:gurus,email',
            'telepon' => 'nullable|string|max:20',
        ]);

        Guru::create($request->all());
        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan');
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nama'    => 'required|string|max:100',
            'nip'     => 'required|string|max:30|unique:gurus,nip,' . $guru->id,
            'email'   => 'required|email|unique:gurus,email,' . $guru->id,
            'telepon' => 'nullable|string|max:20',
        ]);

        $guru->update($request->all());
        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil diperbarui');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus');
    }
}