@extends('layouts.app')

@section('title', 'Monitoring Skripsi')

@section('styles')
<style>
    .container-dosen {
        background: white;
        min-height: 100vh;
        padding: 20px 16px;
    }

    .monitoring-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #e8e8e8;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .student-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
    }

    .student-info {
        flex: 1;
    }

    .student-name {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin-bottom: 4px;
    }

    .student-nim {
        font-size: 13px;
        color: #999;
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-completed {
        background: #d4f4dd;
        color: #2ed573;
    }

    .badge-pending {
        background: #fff4d6;
        color: #ffa502;
    }

    .badge-overdue {
        background: #ffd6d6;
        color: #ff4757;
    }

    .progress-section {
        margin: 16px 0;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .progress-label {
        font-size: 13px;
        font-weight: 600;
        color: #666;
    }

    .progress-value {
        font-size: 13px;
        font-weight: 600;
        color: #667eea;
    }

    .progress-bar {
        background: #f0f0f0;
        border-radius: 8px;
        height: 8px;
        overflow: hidden;
    }

    .progress-fill {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        height: 100%;
        transition: width 0.3s ease;
    }

    .chapters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(90px, 1fr));
        gap: 8px;
        margin: 12px 0;
    }

    .chapter-item {
        background: #f9f9f9;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        font-size: 12px;
    }

    .chapter-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .chapter-status {
        font-size: 11px;
        padding: 3px 6px;
        border-radius: 4px;
        font-weight: 600;
    }

    .status-approved {
        background: #d4f4dd;
        color: #2ed573;
    }

    .status-rejected {
        background: #ffd6d6;
        color: #ff4757;
    }

    .status-review {
        background: #fff4d6;
        color: #ffa502;
    }

    .feedback-alert {
        background: #fff5f5;
        border: 1px solid #ffdddd;
        border-left: 4px solid #ff6b6b;
        border-radius: 6px;
        padding: 12px;
        margin: 12px 0;
        font-size: 13px;
    }

    .feedback-count {
        font-weight: 600;
        color: #ff6b6b;
    }

    .deadline-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #666;
        margin-top: 12px;
    }

    .deadline-date {
        font-weight: 600;
        color: #333;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        margin-top: 12px;
    }

    .btn-action {
        flex: 1;
        padding: 10px;
        border-radius: 6px;
        border: none;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-feedback {
        background: #667eea;
        color: white;
    }

    .btn-feedback:hover {
        background: #5568d3;
    }

    .btn-schedule {
        background: #764ba2;
        color: white;
    }

    .btn-schedule:hover {
        background: #653b8a;
    }

    .statistics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 12px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border: 2px solid #667eea;
        border-radius: 8px;
        padding: 16px;
        text-align: center;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 12px;
        color: #999;
        font-weight: 600;
    }

    .filter-section {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 8px 16px;
        border-radius: 6px;
        border: 2px solid #e8e8e8;
        background: white;
        font-size: 13px;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-btn.active {
        border-color: #667eea;
        background: #667eea;
        color: white;
    }

    .filter-btn:hover {
        border-color: #667eea;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 12px;
    }

    .empty-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .empty-text {
        font-size: 14px;
        color: #999;
    }
</style>
@endsection

@section('content')
<div class="container-dosen">
    <!-- Page Header -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">📚 Monitoring Skripsi Mahasiswa</h1>
        <p style="font-size: 14px; color: #999; margin-top: 4px;">Monitor progress pembimbingan skripsi mahasiswa yang Anda bimbing</p>
    </div>

    <!-- Statistics -->
    <div class="statistics-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $statistics['total_students'] }}</div>
            <div class="stat-label">Total Mahasiswa</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $statistics['completed_defense'] }}</div>
            <div class="stat-label">Sudah Sidang</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $statistics['pending_defense'] }}</div>
            <div class="stat-label">Pending Sidang</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $statistics['total_feedback_pending'] }}</div>
            <div class="stat-label">Feedback Pending</div>
        </div>
    </div>

    <!-- Monitoring List -->
    @if(empty($thesisMonitoring) || count($thesisMonitoring) === 0)
        <div class="empty-state">
            <div class="empty-icon">📚</div>
            <div class="empty-title">Belum ada mahasiswa untuk dibimbing</div>
            <div class="empty-text">Anda belum memiliki mahasiswa skripsi yang ditugaskan sebagai pembimbing</div>
        </div>
    @else
        @foreach($thesisMonitoring as $monitoring)
        <div class="monitoring-card">
            <!-- Student Header -->
            <div class="student-header">
                <div class="student-info">
                    <div class="student-name">{{ $monitoring['student_name'] }}</div>
                    <div class="student-nim">NIM: {{ $monitoring['student_nim'] }} • {{ $monitoring['advisor_role'] }}</div>
                </div>
                <div>
                    @if($monitoring['status'] === 'completed')
                        <span class="badge badge-completed">✓ Selesai</span>
                    @elseif($monitoring['days_until_defense'] !== null && $monitoring['days_until_defense'] < 0)
                        <span class="badge badge-overdue">⚠ Overdue</span>
                    @else
                        <span class="badge badge-pending">⏱ Pending</span>
                    @endif
                </div>
            </div>

            <!-- Thesis Title -->
            <div style="margin-bottom: 12px;">
                <p style="font-size: 14px; color: #333; font-weight: 600; margin: 0 0 4px 0;">{{ $monitoring['thesis']->title }}</p>
            </div>

            <!-- Progress Section -->
            <div class="progress-section">
                <div class="progress-header">
                    <span class="progress-label">Progress Pengumpulan Bab</span>
                    <span class="progress-value">{{ $monitoring['submitted_chapters'] }}/{{ $monitoring['total_chapters'] }} Bab ({{ round($monitoring['progress_percentage']) }}%)</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $monitoring['progress_percentage'] }}%;"></div>
                </div>
            </div>

            <!-- Chapters Grid -->
            <div class="chapters-grid">
                @php
                    $chapterNames = ['Bab 1', 'Bab 2', 'Bab 3', 'Bab 4', 'Bab 5'];
                @endphp
                @for($i = 1; $i <= 5; $i++)
                    @php
                        $submission = collect($monitoring['submissions'])->first(fn($s) => strpos($s['chapter'], (string)$i) !== false);
                    @endphp
                    <div class="chapter-item">
                        <div class="chapter-name">{{ $chapterNames[$i-1] }}</div>
                        @if($submission)
                            @if($submission['status'] === 'approved')
                                <div class="chapter-status status-approved">✓ Disetujui</div>
                            @elseif($submission['status'] === 'rejected')
                                <div class="chapter-status status-rejected">✕ Revisi</div>
                            @else
                                <div class="chapter-status status-review">⏱ Review</div>
                            @endif
                        @else
                            <div class="chapter-status" style="background: #f0f0f0; color: #999;">-</div>
                        @endif
                    </div>
                @endfor
            </div>

            <!-- Feedback Alert -->
            @if($monitoring['unresolved_feedback'] > 0)
            <div class="feedback-alert">
                <span class="feedback-count">⚠️ {{ $monitoring['unresolved_feedback'] }} Feedback Belum Direspon</span>
                <div style="font-size: 12px; color: #ff6b6b; margin-top: 4px;">
                    Total feedback: {{ $monitoring['total_feedback'] }}
                </div>
            </div>
            @endif

            <!-- Deadline Info -->
            @if($monitoring['defense_deadline'])
                <div class="deadline-info">
                    <span>📅 Jadwal Sidang:</span>
                    <span class="deadline-date">{{ $monitoring['defense_deadline']->format('d M Y') }}</span>
                    @if($monitoring['days_until_defense'] !== null)
                        @if($monitoring['days_until_defense'] >= 0)
                            <span style="color: #2ed573;">({{ $monitoring['days_until_defense'] }} hari lagi)</span>
                        @else
                            <span style="color: #ff6b6b;">({{ abs($monitoring['days_until_defense']) }} hari terlewat)</span>
                        @endif
                    @endif
                </div>
            @else
                <div class="deadline-info">
                    <span>📅 Jadwal Sidang:</span>
                    <span class="deadline-date">Belum dijadwalkan</span>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('mahasiswa.feedback') }}" class="btn-action btn-feedback">
                    💬 Lihat Feedback
                </a>
                <a href="{{ route('mahasiswa.schedule') }}" class="btn-action btn-schedule">
                    📋 Detail Bab
                </a>
            </div>
        </div>
        @endforeach
    @endif

    <!-- Back to Dashboard -->
    <div style="margin-top: 32px; text-align: center;">
        <a href="{{ route('dosen.dashboard') }}" style="display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: background 0.2s;">
            ← Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
