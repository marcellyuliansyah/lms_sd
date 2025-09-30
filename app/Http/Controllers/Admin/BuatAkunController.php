<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BuatAkunController extends Controller
{
    public function index() {
        return view('admin.buatakun.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,guru',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        if ($request->role === 'guru') {
        Guru::create([
            'nama'     => $request->name,
            'nip'      => null,
            'email'    => $request->email,
            'telepon'  => null,
            'password' => $request->password, // disimpan plain text
            'user_id'  => $user->id,
        ]);
    }

        return redirect()->route('admin.buatakun.index')->with('success', 'Akun ' . $request->role . ' berhasil dibuat.');
    }
}
