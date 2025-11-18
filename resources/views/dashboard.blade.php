@extends('layout')

@section('title', 'Dashboard')

@section('styles')
<style>
    .task-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    
    /* EMPHASIS - Urgent Card */
    .task-card.urgent {
        border: 4px solid #ff4757;
        background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
        padding: 18px;
        box-shadow: 0 4px 20px rgba(255,71,87,0.3);
    }
    
    .task-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 8px;
    }
    
    .task-title.big {
        font-size: 20px;
        color: #ff4757;
    }
    
    .task-meta {
        font-size: 13px;
        color: #666;
    }
    
    .badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .badge-red { background: #ff4757; color: white; }
    .badge-yellow { background: #ffa502; color: white; }
    .badge-green { background: #2ed573; color: white; }
    
    .nav-bottom {
        position: sticky;
        bottom: 0;
        background: white;
        padding: 15px;
        display: flex;
        justify-content: space-around;
        border-top: 1px solid #e0e0e0;
    }
    
    .nav-item {
        text-align: center;
        text-decoration: none;
        color: #999;
        font-size: 12px;
    }
    
    .nav-item.active {
        color: #667eea;
    }
    
    .nav-icon {
        font-size: 24px;
        display: block;
        margin-bottom: 5px;
    }
</style>
@endsection

@section('content')
<div class="header">
    <div class="header-title">
        <span>☰</span>
        <span>Dashboard</span>
    </div>
    <div class="header-icons">
        <a href="#">🔍</a>
        <a href="#">🔔<sup style="background:red;border-radius:50%;padding:2px 5px;font-size:10px;">3</sup></a>
    </div>
</div>

<div class="content">
    <!-- EMPHASIS: Urgent Task -->
    <a href="{{ route('detail-tugas', ['id' => 1]) }}" class="task-card urgent">
        <div class="badge badge-red">🔴 URGENT!</div>
        <div class="task-title big">UAS Pemrograman Web</div>
        <div class="task-meta">⏰ 22 Oktober 2025, 23:59</div>
        <div class="task-meta">👤 Pak Budi Santoso</div>
    </a>
    
    <!-- Normal Task -->
    <a href="{{ route('detail-tugas', ['id' => 2]) }}" class="task-card">
        <div class="badge badge-yellow">Normal</div>
        <div class="task-title">Lab Basis Data</div>
        <div class="task-meta">⏰ 28 Oktober 2025, 17:00</div>
    </a>
    
    <!-- Low Priority Task -->
    <a href="{{ route('detail-tugas', ['id' => 3]) }}" class="task-card">
        <div class="badge badge-green">Rendah</div>
        <div class="task-title">Essay Bahasa Inggris</div>
        <div class="task-meta">⏰ 5 November 2025, 23:59</div>
    </a>
    
    <button class="btn btn-primary" style="margin-top: 15px;">+ Tambah Tugas</button>
</div>

<div class="nav-bottom">
    <a href="{{ route('dashboard') }}" class="nav-item active">
        <span class="nav-icon">🏠</span>
        Dashboard
    </a>
    <a href="{{ route('per-mk') }}" class="nav-item">
        <span class="nav-icon">📚</span>
        Per MK
    </a>
    <a href="{{ route('kalender') }}" class="nav-item">
        <span class="nav-icon">📅</span>
        Kalender
    </a>
    <a href="{{ route('dashboard-skripsi') }}" class="nav-item">
        <span class="nav-icon">📝</span>
        Skripsi
    </a>
</div>
@endsection