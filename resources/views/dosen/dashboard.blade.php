@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('styles')
<style>
    .container-dosen {
        background: white;
        min-height: 100vh;
        padding: 20px 16px;
    }

    .task-card {
        background: white;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 20px;
        border: 1px solid #e8e8e8;
    }

    .task-header {
        margin-bottom: 16px;
    }

    .task-title {
        font-size: 15px;
        font-weight: 700;
        color: #333;
        margin-bottom: 4px;
    }

    .task-deadline {
        font-size: 12px;
        color: #999;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-tepat {
        background: #d4f4dd;
        color: #2ed573;
    }

    .status-bakun {
        background: #fff4d6;
        color: #ffa502;
    }

    .status-telat {
        background: #ffd6d6;
        color: #ff4757;
    }

    .statistics-box {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px 16px;
        border-radius: 12px;
        color: white;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .stat-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.95);
        font-weight: 500;
    }

    @media (max-width: 640px) {
        .container-dosen {
            padding: 16px 12px;
        }

        .task-card {
            padding: 12px;
            margin-bottom: 16px;
        }

        .table-header,
        .table-row {
            padding: 10px 12px;
            font-size: 12px;
        }

        .header-nama,
        .cell-nama {
            flex: 0 0 50%;
        }

        .header-status,
        .cell-status {
            flex: 0 0 30%;
            text-align: center;
        }

        .header-waktu,
        .cell-waktu {
            flex: 0 0 20%;
            text-align: right;
        }

        .task-title {
            font-size: 14px;
        }

        .stat-number {
            font-size: 24px;
        }

        .stat-label {
            font-size: 11px;
        }

        .statistics-box {
            padding: 16px 12px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-dosen">
    <!-- Page Header -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 28px; font-weight: 700; color: #333; margin: 0;">Dashboard Dosen</h1>
        <p style="font-size: 14px; color: #999; margin-top: 4px;">Selamat datang, {{ Auth::user()->name }}</p>
    </div>

    <!-- Statistics Summary -->
    <div class="statistics-box">
        <div class="stat-item">
            <div class="stat-number">{{ $statistics['total_courses'] }}</div>
            <div class="stat-label">Mata Kuliah</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $statistics['total_tasks'] }}</div>
            <div class="stat-label">Total Tugas</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $statistics['overdue_tasks'] }}</div>
            <div class="stat-label">Overdue</div>
        </div>
    </div>

    @if($courses->isEmpty())
        <div style="text-align: center; padding: 40px 20px; color: #999;">
            <p>Anda belum mengampu mata kuliah apapun</p>
        </div>
    @else
        <!-- Tasks by Course -->
        @foreach($task_stats as $stat)
            <div class="task-card">
                <div class="task-header">
                    <div class="task-title">{{ $stat['task']->title }}</div>
                    <div class="task-deadline">
                        Mata Kuliah: {{ $stat['task']->course->name }} | 
                        Deadline: {{ $stat['task']->deadline->format('d M, H:i') }}
                    </div>
                </div>

                <!-- Submission Statistics -->
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 16px; padding: 12px 0; border-top: 1px solid #e8e8e8;">
                    <div style="text-align: center;">
                        <div style="font-size: 18px; font-weight: 700; color: #667eea;">{{ $stat['submitted'] }}</div>
                        <div style="font-size: 12px; color: #999;">Dikumpulkan</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 18px; font-weight: 700; color: #ff6b6b;">{{ $stat['pending'] }}</div>
                        <div style="font-size: 12px; color: #999;">Belum Kumpul</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 18px; font-weight: 700; color: #2ed573;">{{ $stat['approved'] }}</div>
                        <div style="font-size: 12px; color: #999;">Disetujui</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 18px; font-weight: 700; color: #ffa502;">{{ $stat['rejected'] }}</div>
                        <div style="font-size: 12px; color: #999;">Ditolak</div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div style="background: #f0f0f0; border-radius: 8px; height: 8px; margin-bottom: 12px; overflow: hidden;">
                    <div style="background: linear-gradient(90deg, #2ed573 0%, #667eea 100%); height: 100%; width: {{ ($stat['submitted'] / $stat['total_enrolled']) * 100 }}%;"></div>
                </div>

                <!-- Submission List -->
                <div style="max-height: 300px; overflow-y: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f9f9f9; border-bottom: 1px solid #e8e8e8;">
                                <th style="padding: 10px 12px; text-align: left; font-size: 12px; font-weight: 700; color: #666;">Nama</th>
                                <th style="padding: 10px 12px; text-align: center; font-size: 12px; font-weight: 700; color: #666;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stat['task']->completions as $completion)
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td style="padding: 10px 12px; text-align: left; font-size: 12px; color: #333;">{{ $completion->user->name }}</td>
                                    <td style="padding: 10px 12px; text-align: center;">
                                        @if($completion->status === 'approved')
                                            <span class="status-badge status-tepat">✓ Disetujui</span>
                                        @elseif($completion->status === 'rejected')
                                            <span class="status-badge status-telat">✕ Ditolak</span>
                                        @else
                                            <span class="status-badge status-bakun">⏱ {{ ucfirst($completion->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" style="padding: 20px 12px; text-align: center; color: #999; font-size: 12px;">
                                        Belum ada pengumpulan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif

    <!-- Quick Action Button -->
    <div style="margin-top: 24px; margin-bottom: 40px;">
        <a href="{{ route('dosen.reminder') }}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: transform 0.2s;">
            ➜ Atur Reminder
        </a>
    </div>
</div>
@endsection
