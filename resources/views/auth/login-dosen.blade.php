@extends('layouts.app')

@section('title', 'Login Dosen')

@section('styles')
<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .login-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        padding: 40px 18px 28px 18px;
        width: 100%;
        max-width: 440px;
        animation: fadeInUp 0.6s ease;
    }
    
    @media (max-width: 480px) {
        .login-card {
            padding: 18px 4vw 18px 4vw;
            border-radius: 14px;
            max-width: 98vw;
        }
        .login-card h1 {
            font-size: 1.5rem;
        }
        .login-card p, .login-card label, .login-card input, .login-card button {
            font-size: 1rem;
        }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
    
    .btn-login {
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
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }
    
    .divider {
        text-align: center;
        margin: 28px 0;
        position: relative;
    }
    
    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e0e0e0;
    }
    
    .divider span {
        background: white;
        padding: 0 16px;
        position: relative;
        color: #999;
        font-size: 14px;
    }
    
    .dosen-badge {
        display: inline-block;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 8px;
    }
</style>
@endsection

@section('content')
<div class="login-card">
    <!-- Logo & Title -->
    <div class="text-center mb-10">
        <div class="text-6xl mb-4">👨‍🏫</div>
        <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent mb-2">
            EduDeadline
        </h1>
        <p class="text-gray-600">Portal Dosen</p>
        <span class="dosen-badge">Akses Khusus Pengajar</span>
    </div>
    
    <!-- Error Messages -->
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
        <p class="text-red-700 font-medium">{{ $errors->first() }}</p>
    </div>
    @endif

    <!-- Success Messages -->
    @if (session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
        <p class="text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif
    
    <!-- Login Form -->
    <form action="{{ route('dosen.login.post') }}" method="POST">
        @csrf
        
        <div class="input-group">
            <span class="input-icon">📧</span>
            <input 
                type="text" 
                name="email" 
                placeholder="Email atau NIP" 
                value="{{ old('email') }}"
                required
                autofocus
            >
        </div>
        
        <div class="input-group">
            <span class="input-icon">🔒</span>
            <input 
                type="password" 
                name="password" 
                placeholder="Password" 
                required
            >
        </div>
        
        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300">
                <span>Ingat Saya</span>
            </label>
            <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                Lupa Password?
            </a>
        </div>
        
        <button type="submit" class="btn-login">
            MASUK
        </button>
    </form>
    
    <div class="divider">
        <span>atau</span>
    </div>
    
    <!-- Links -->
    <div class="text-center space-y-3">
        <p class="text-gray-600 text-sm">
            Belum punya akun? 
            <a href="{{ route('dosen.register') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                Daftar Sebagai Dosen
            </a>
        </p>
        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-700 font-medium text-sm inline-flex items-center gap-2">
            <span>🎓</span>
            <span>Masuk sebagai Mahasiswa</span>
            <span>→</span>
        </a>
    </div>
</div>
@endsection
