<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Register user baru (Guru / Siswa)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:admin,guru,siswa',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        Auth::login($user);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user'    => $user
        ]);
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'guru') {
                return redirect()->route('guru.dashboard');
            } elseif ($user->role === 'siswa') {
                return redirect()->route('siswa.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();                      // Logout user
        $request->session()->invalidate();    // Hapus session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect()->route('login.form'); // Redirect ke halaman login
    }
}
