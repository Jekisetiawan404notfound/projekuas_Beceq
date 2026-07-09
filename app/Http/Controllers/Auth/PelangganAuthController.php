<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PelangganAuthController extends Controller
{
    /**
     * Tampilkan form registrasi pelanggan.
     */
    public function showRegisterForm()
    {
        if (Auth::guard('pelanggan')->check()) {
            return redirect('/dashboard');
        }

        return view('auth.pelanggan-register');
    }

    /**
     * Proses registrasi pelanggan baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'username' => 'required|string|max:255|unique:pelanggans,username',
            'password' => 'required|string|min:6',
            'password2' => 'required|string|same:password',
        ], [
            'password2.same' => 'Konfirmasi password tidak sesuai.',
        ]);

        Pelanggan::create([
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'no_telepon' => $validated['no_telepon'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    /**
     * Tampilkan form login pelanggan.
     */
    public function showLoginForm()
    {
        if (Auth::guard('pelanggan')->check()) {
            return redirect('/dashboard');
        }

        return view('auth.pelanggan-login');
    }

    /**
     * Proses login pelanggan.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('pelanggan')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()
            ->withErrors(['login' => 'Username / Password salah!'])
            ->onlyInput('username');
    }

    /**
     * Proses logout pelanggan.
     */
    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
