@extends('layout')

@section('title', 'Login')

@section('content')
<div class="login-screen">
    <div class="logo">📚</div>
    <div class="app-name">EduDeadline</div>
    
    <input type="text" class="input" placeholder="📧 Email/NIM" style="background: rgba(255,255,255,0.9);">
    <input type="password" class="input" placeholder="🔒 Password" style="background: rgba(255,255,255,0.9);">
    
    <a href="{{ route('dashboard') }}" class="btn btn-primary" style="background: white; color: #667eea;">
        MASUK
    </a>
    
    <div style="margin-top: 20px; font-size: 14px;">
        <a href="#" style="color: white;">Lupa Password?</a> | 
        <a href="#" style="color: white;">Daftar</a>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="{{ route('dashboard-dosen') }}" style="color: white; font-size: 14px;">
            Masuk sebagai Dosen →
        </a>
    </div>
</div>
@endsection