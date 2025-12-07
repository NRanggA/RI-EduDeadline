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
    <!-- Task Card -->
    <div class="task-card">
        <div class="task-header">
            <div class="task-title">Tugas : UAS Akhir Semester</div>
            <div class="task-deadline">Deadline : 22 Okt, 23:59</div>
        </div>

    <!-- Table -->
    <table style="width: 100%; border-collapse: collapse; border-radius: 8px; overflow: hidden; border: 1px solid #e8e8e8;">
        <thead>
            <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <th style="padding: 12px 16px; text-align: left; font-size: 13px; font-weight: 700; width: 40%; border: none;">Nama</th>
                <th style="padding: 12px 16px; text-align: center; font-size: 13px; font-weight: 700; width: 35%; border: none;">Status</th>
                <th style="padding: 12px 16px; text-align: right; font-size: 13px; font-weight: 700; width: 25%; border: none;">Waktu</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom: 1px solid #e8e8e8;">
                <td style="padding: 12px 16px; text-align: left; font-weight: 600; color: #333; width: 40%;">Ahmad Fauzi</td>
                <td style="padding: 12px 16px; text-align: center; width: 35%;"><span class="status-badge status-tepat">✓ Tepat</span></td>
                <td style="padding: 12px 16px; text-align: right; color: #666; font-size: 12px; width: 25%;">09:30</td>
            </tr>
            <tr style="border-bottom: 1px solid #e8e8e8;">
                <td style="padding: 12px 16px; text-align: left; font-weight: 600; color: #333; width: 40%;">Budi Santoso</td>
                <td style="padding: 12px 16px; text-align: center; width: 35%;"><span class="status-badge status-bakun">⏱ Bakun</span></td>
                <td style="padding: 12px 16px; text-align: right; color: #666; font-size: 12px; width: 25%;">-</td>
            </tr>
            <tr style="border-bottom: 1px solid #e8e8e8;">
                <td style="padding: 12px 16px; text-align: left; font-weight: 600; color: #333; width: 40%;">Citra Dewi</td>
                <td style="padding: 12px 16px; text-align: center; width: 35%;"><span class="status-badge status-telat">✕ Telat</span></td>
                <td style="padding: 12px 16px; text-align: right; color: #666; font-size: 12px; width: 25%;">23:45</td>
            </tr>
            <tr>
                <td style="padding: 12px 16px; text-align: left; font-weight: 600; color: #333; width: 40%;">Dewi Lestari</td>
                <td style="padding: 12px 16px; text-align: center; width: 35%;"><span class="status-badge status-tepat">✓ Tepat</span></td>
                <td style="padding: 12px 16px; text-align: right; color: #666; font-size: 12px; width: 25%;">08:15</td>
            </tr>
        </tbody>
    </table>
    </div>

    <!-- Statistics -->
    <div class="statistics-box">
        <div class="stat-item">
            <div class="stat-number">2 ✓</div>
            <div class="stat-label">Tepat</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">1 ⏱</div>
            <div class="stat-label">Bakun</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">1 ✕</div>
            <div class="stat-label">Telat</div>
        </div>
    </div>
</div>
@endsection
