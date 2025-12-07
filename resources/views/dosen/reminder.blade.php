@extends('layouts.app')

@section('title', 'Setup Reminder')

@section('styles')
<style>
    .container-reminder {
        background: white;
        min-height: 100vh;
        padding: 20px 16px;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #667eea;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 20px;
        cursor: pointer;
        transition: color 0.3s;
    }

    .back-button:hover {
        color: #764ba2;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 24px;
    }

    .reminder-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #e8e8e8;
    }

    .reminder-label {
        font-size: 14px;
        font-weight: 700;
        color: #333;
        margin-bottom: 12px;
        display: block;
    }

    .checkbox-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
    }

    .checkbox-item:hover {
        background: #f8f9ff;
        border-color: #667eea;
    }

    .checkbox-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #667eea;
    }

    .checkbox-label {
        font-size: 14px;
        color: #666;
        flex: 1;
        cursor: pointer;
        user-select: none;
    }

    .input-group {
        margin-bottom: 20px;
    }

    .input-field {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s;
        color: #666;
    }

    .input-field:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .input-field::placeholder {
        color: #ccc;
    }

    .textarea-field {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        min-height: 100px;
        resize: vertical;
        transition: all 0.3s;
        color: #666;
    }

    .textarea-field:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .textarea-field::placeholder {
        color: #ccc;
    }

    .btn-reminder {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-reminder:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-reminder:active {
        transform: translateY(0);
    }

    .success-message {
        background: #d4f4dd;
        border-left: 4px solid #2ed573;
        color: #2ed573;
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    .error-message {
        background: #ffd6d6;
        border-left: 4px solid #ff4757;
        color: #ff4757;
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    @media (max-width: 640px) {
        .container-reminder {
            padding: 16px 12px;
        }

        .page-title {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .reminder-card {
            padding: 16px;
            margin-bottom: 16px;
        }

        .checkbox-item {
            padding: 10px;
            gap: 10px;
        }

        .checkbox-label {
            font-size: 13px;
        }

        .btn-reminder {
            padding: 12px;
            font-size: 14px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-reminder">
    <!-- Back Button -->
    <a href="{{ route('dosen.dashboard') }}" class="back-button">
        <span>←</span>
        <span>Kembali</span>
    </a>

    <!-- Page Title -->
    <h1 class="page-title">Setup Reminder</h1>

    <!-- Success Message -->
    @if (session('success'))
    <div class="success-message">
        {{ session('success') }}
    </div>
    @endif

    <!-- Error Message -->
    @if ($errors->any())
    <div class="error-message">
        {{ $errors->first() }}
    </div>
    @endif

    <!-- Reminder Form -->
    <form action="{{ route('dosen.reminder.send') }}" method="POST">
        @csrf

        <!-- Section 1: Kirim reminder ke -->
        <div class="reminder-card">
            <label class="reminder-label">Kirim reminder ke:</label>
            <div class="checkbox-group">
                <label class="checkbox-item">
                    <input type="checkbox" name="recipient" value="semua_mahasiswa">
                    <span class="checkbox-label">Semua Mahasiswa</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="recipient" value="belum_mengumpulkan">
                    <span class="checkbox-label">Yang Belum Mengumpulkan</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" name="recipient" value="terlambat">
                    <span class="checkbox-label">Yang Terlambat</span>
                </label>
            </div>
        </div>

        <!-- Section 2: Waktu Pengingat -->
        <div class="reminder-card">
            <label class="reminder-label">Waktu Pengingat:</label>
            <div class="input-group">
                <input 
                    type="text" 
                    name="waktu_pengingat" 
                    class="input-field" 
                    placeholder="1 hari sebelum deadline"
                    value="{{ old('waktu_pengingat') }}"
                    required
                >
            </div>
        </div>

        <!-- Section 3: Template Pesan -->
        <div class="reminder-card">
            <label class="reminder-label">Template pesan:</label>
            <div class="input-group">
                <textarea 
                    name="template_pesan" 
                    class="textarea-field" 
                    placeholder="Halo, ini pengingat untuk tugas UAS. Deadline 22 Oktober 2025."
                    required
                >{{ old('template_pesan', 'Halo, ini pengingat untuk tugas UAS. Deadline 22 Oktober 2025.') }}</textarea>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-reminder">
            Atur Reminder
        </button>
    </form>
</div>
@endsection
