@extends('layouts.app')

@section('title', 'Register Dosen')

@section('styles')
<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
    
    .input-group input,
    .input-group select {
        width: 100%;
        padding: 16px 16px 16px 50px;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s;
        font-family: inherit;
    }
    
    .input-group input:focus,
    .input-group select:focus {
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
    
    .requirements {
        background: #f0f4ff;
        border-left: 4px solid #667eea;
        padding: 12px 16px;
        border-radius: 8px;
        margin-top: 16px;
        font-size: 13px;
        color: #555;
        line-height: 1.5;
    }
</style>
@endsection

@section('content')
<div class="register-card">
    <!-- Logo & Title -->
    <div class="text-center mb-10">
        <div class="text-6xl mb-4">👨‍🏫</div>
        <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent mb-2">
            EduDeadline
        </h1>
        <p class="text-gray-600">Daftar sebagai Dosen</p>
        <span class="dosen-badge">Portal Khusus Pengajar</span>
    </div>
    
    <!-- Error Messages -->
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
        <ul class="text-red-700 text-sm">
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <!-- Register Form -->
    <form method="POST" action="{{ route('dosen.register.post') }}">
        @csrf
        
        <div class="input-group">
            <span class="input-icon">👤</span>
            <input 
                type="text" 
                name="name" 
                placeholder="Nama Lengkap" 
                value="{{ old('name') }}" 
                required 
                autofocus
            >
        </div>
        
        <div class="input-group">
            <span class="input-icon">📧</span>
            <input 
                type="email" 
                name="email" 
                placeholder="Email Institusi" 
                value="{{ old('email') }}" 
                required
            >
        </div>
        
        <div class="input-group">
            <span class="input-icon">🆔</span>
            <input 
                type="text" 
                name="nim" 
                placeholder="NIP (Nomor Induk Pegawai)" 
                value="{{ old('nim') }}" 
                required
            >
        </div>
        
        <div class="input-group">
            <span class="input-icon">🏫</span>
            <input 
                type="text" 
                name="department" 
                placeholder="Departemen/Jurusan" 
                value="{{ old('department') }}"
            >
        </div>
        
        <div class="input-group">
            <span class="input-icon">🔒</span>
            <input 
                type="password" 
                name="password" 
                placeholder="Password (minimal 8 karakter)" 
                required
            >
        </div>
        
        <div class="input-group">
            <span class="input-icon">🔒</span>
            <input 
                type="password" 
                name="password_confirmation" 
                placeholder="Konfirmasi Password" 
                required
            >
        </div>
        
        <button type="submit" class="btn-register">
            DAFTAR SEBAGAI DOSEN
        </button>
    </form>
    
    <!-- Requirements -->
    <div class="requirements">
        <strong style="color: #667eea;">📋 Catatan Pendaftaran:</strong><br>
        • Gunakan email institusi resmi Anda<br>
        • NIP harus valid dan terdaftar di sistem<br>
        • Password minimal 8 karakter
    </div>
    
    <!-- Links -->
    <div class="text-center space-y-3 mt-6">
        <p class="text-gray-600 text-sm">
            Sudah punya akun?
            <a href="{{ route('dosen.login') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                Masuk Di Sini
            </a>
        </p>
        <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-700 font-medium text-sm inline-flex items-center gap-2">
            <span>🎓</span>
            <span>Daftar sebagai Mahasiswa</span>
            <span>→</span>
        </a>
    </div>
</div>
@endsection
