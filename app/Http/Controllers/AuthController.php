<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('mahasiswa.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba login dengan email atau NIM
        $loginField = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        if (Auth::attempt([$loginField => $credentials['email'], 'password' => $credentials['password']], $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role === 'dosen') {
                return redirect()->route('dosen.dashboard');
            }

            return redirect()->route('mahasiswa.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email/NIM atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nim' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:mahasiswa,dosen',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nim' => $validated['nim'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        Auth::login($user);

        if ($user->role === 'dosen') {
            return redirect()->route('dosen.dashboard');
        }
        return redirect()->route('mahasiswa.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
