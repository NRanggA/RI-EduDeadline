@extends('layout')

@section('title', 'Detail Tugas')

@section('styles')
<style>
    .detail-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 3px solid #667eea;
    }
    
    .detail-section {
        margin-bottom: 25px;
    }
    
    .detail-label {
        font-size: 13px;
        color: #999;
        margin-bottom: 8px;
    }
    
    .detail-value {
        font-size: 15px;
        color: #333;
        font-weight: 500;
    }
    
    .deadline-highlight {
        color: #ff4757;
        font-size: 18px;
        font-weight: bold;
    }
    
    .attachment {
        background: #f0f0f0;
        padding: 12px 15px;
        border-radius: 10px;
        display: inline-block;
        font-size: 14px;
        margin-top: 8px;
    }
    
    .status-badge {
        background: #ffa502;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        display: inline-block;
        font-size: 14px;
        font-weight: bold;
        margin-top: 8px;
    }
</style>
@endsection

@section('content')
<div class="header">
    <div class="header-title">
        <a href="{{ route('dashboard') }}">←</a>
        <span>Detail Tugas</span>
    </div>
</div>

<div class="content">
    <div class="detail-title">UAS Pemrograman Web</div>
    
    <div class="detail-section">
        <div class="detail-label">📚 Mata Kuliah:</div>
        <div class="detail-value">Pemrograman Web B</div>
    </div>
    
    <div class="detail-section">
        <div class="detail-label">👤 Dosen:</div>
        <div class="detail-value">Budi Santoso, M.Kom</div>
    </div>
    
    <div class="detail-section">
        <div class="detail-label">⏰ Deadline:</div>
        <div class="detail-value deadline-highlight">
            22 Oktober 2025, 23:59<br>
            <span style="font-size: 14px;">(3 hari lagi)</span>
        </div>
    </div>
    
    <div class="detail-section">
        <div class="detail-label">📝 Deskripsi:</div>
        <div class="detail-value">
            Buat website e-commerce dengan Laravel, MySQL, dan Bootstrap. Harus ada fitur login, CRUD produk, dan keranjang belanja.
        </div>
    </div>
    
    <div class="detail-section">
        <div class="detail-label">📎 Lampiran:</div>
        <div class="attachment">📄 soal_uas.pdf</div>
    </div>
    
    <div class="detail-section">
        <div class="detail-label">Status:</div>
        <div class="status-badge">⭕ Belum Selesai</div>
    </div>
    
    <div class="flex gap-10" style="margin-top: 30px;">
        <button class="btn btn-success" style="flex: 1;">Tandai Selesai</button>
        <button class="btn btn-secondary" style="flex: 1;">Edit</button>
    </div>
</div>
@endsection