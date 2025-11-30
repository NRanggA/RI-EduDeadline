
@extends('layouts.app')

@section('title', 'Register')

@section('styles')
<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }
    .register-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        padding: 40px 18px 28px 18px;
        width: 100%;
        max-width: 440px;
        animation: fadeInUp 0.6s ease;
    }
    @media (max-width: 480px) {
        .register-card {
            padding: 18px 4vw 18px 4vw;
            border-radius: 14px;
            max-width: 98vw;
        }
        .register-card h1, .register-title {
            font-size: 1.5rem;
        }
        .register-card p, .register-card label, .register-card input, .register-card button, .register-card select {
            font-size: 1rem;
        }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .input-group {
        position: relative;
        margin-bottom: 24px;
    }
    .input-group input {
        width: 100%;
        padding: 16px 16px 16px 50px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s;
    }
    .input-group input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    .input-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
    }
    .btn-register {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 8px;
    }
    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }
</style>
@endsection

@section('content')
<div class="register-card">
    <!-- Logo & Title -->
    <div class="text-center mb-10">
        <div class="text-6xl mb-4">📚</div>
        <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent mb-2">
            EduDeadline
        </h1>
        <p class="text-gray-600">Buat akun baru untuk mulai</p>
    </div>
    <!-- Error Messages -->
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
        <p class="text-red-700 font-medium">{{ $errors->first() }}</p>
    </div>
    @endif
    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="input-group">
            <span class="input-icon">👤</span>
            <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
        </div>
        <div class="input-group">
            <span class="input-icon">📧</span>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        </div>
        <div class="input-group">
            <span class="input-icon">🎓</span>
            <input type="text" name="nim" placeholder="NIM" value="{{ old('nim') }}" required>
        </div>
        <div class="input-group">
            <span class="input-icon">🔒</span>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="input-group">
            <span class="input-icon">🎓</span>
            <select name="role" required style="width:100%;padding:16px 16px 16px 50px;border:2px solid #e0e0e0;border-radius:12px;font-size:15px;appearance:auto;">
                <option value="mahasiswa" {{ old('role')=='mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="dosen" {{ old('role')=='dosen' ? 'selected' : '' }}>Dosen</option>
            </select>
        </div>
        <button type="submit" class="btn-register">
            REGISTER
        </button>
    </form>
    <div class="text-center space-y-3 mt-6">
        <p class="text-gray-600 text-sm">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                Masuk
            </a>
        </p>
    </div>
</div>
@endsection
