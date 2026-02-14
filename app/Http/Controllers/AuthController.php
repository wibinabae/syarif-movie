<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/movies');
        }

        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Validasi sederhana
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Gunakan manual check untuk user tes
        if ($credentials['username'] === 'aldmic' && $credentials['password'] === '123abc123') {
            // Buat login manual
            session([
                'is_login' => true,
                'user' => 'aldmic',
                'locale' => 'en'
            ]);

            return redirect('/movies');
        }

        return back()->with('error', 'Invalid username or password.');
    }

    // Logout
    public function logout()
    {
        Auth::logout(); // jika pakai Auth
        session()->flush(); // hapus semua session manual
        return redirect('/');
    }
}
