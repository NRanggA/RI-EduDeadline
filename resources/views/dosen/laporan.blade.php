@extends('layouts.app')

@section('title', 'Laporan')

@section('styles')
<style>
    .container-laporan {
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

    .report-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #e8e8e8;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* Tingkat Ketepatan Card */
    .ketepatan-card {
        text-align: center;
        padding: 30px 20px;
    }

    .ketepatan-title {
        font-size: 14px;
        font-weight: 600;
        color: #999;
        margin-bottom: 16px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .ketepatan-percentage {
        font-size: 56px;
        font-weight: 700;
        color: #1dd1a1;
        margin-bottom: 24px;
    }

    .ketepatan-items {
        display: flex;
        flex-direction: column;
        gap: 12px;
        text-align: left;
    }

    .ketepatan-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
    }

    .ketepatan-item:last-child {
        border-bottom: none;
    }

    .ketepatan-label {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #555;
        font-weight: 500;
    }

    .ketepatan-label::before {
        content: '•';
        font-size: 20px;
        color: #667eea;
    }

    .ketepatan-percentage-value {
        color: #666;
        font-weight: 600;
        font-size: 13px;
    }

    /* Grafik Tren Card */
    .grafik-card {
        padding: 20px;
    }

    .grafik-title {
        font-size: 14px;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
    }

    .grafik-container {
        display: flex;
        align-items: flex-end;
        justify-content: center;
        gap: 24px;
        height: 200px;
        padding: 20px 0;
        border-left: 2px solid #333;
        border-bottom: 2px solid #333;
        position: relative;
    }

    .bar-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        max-width: 60px;
    }

    .bar {
        width: 100%;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        border-radius: 4px 4px 0 0;
        transition: all 0.3s;
        cursor: pointer;
        min-height: 20px;
    }

    .bar:hover {
        opacity: 0.8;
        filter: brightness(1.1);
    }

    .bar-label {
        margin-top: 12px;
        font-size: 12px;
        font-weight: 600;
        color: #555;
        text-align: center;
    }

    /* Axes Labels */
    .axis-label {
        font-size: 12px;
        color: #999;
        font-weight: 500;
    }

    .y-axis {
        position: absolute;
        left: 10px;
        top: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-size: 14px;
        color: black;
    }

    .y-axis-label {
        height: 0;
        display: flex;
        align-items: center;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 24px;
    }

    .stat-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 16px;
        border-radius: 8px;
        text-align: center;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
    }

    /* Filter Section */
    .filter-section {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 8px 16px;
        border: 1px solid #e8e8e8;
        background: white;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        transition: all 0.3s;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-color: transparent;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .container-laporan {
            padding: 16px 12px;
        }

        .page-title {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .report-card {
            padding: 16px;
            margin-bottom: 16px;
        }

        .ketepatan-percentage {
            font-size: 48px;
        }

        .ketepatan-item {
            padding: 8px 0;
            font-size: 12px;
        }

        .grafik-container {
            height: 160px;
            gap: 16px;
        }

        .bar-group {
            max-width: 50px;
        }

        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .stat-value {
            font-size: 20px;
        }

        .stat-label {
            font-size: 10px;
        }

        .filter-section {
            gap: 8px;
        }

        .filter-btn {
            padding: 6px 12px;
            font-size: 12px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-laporan">
    <!-- Back Button -->
    <a href="{{ route('dosen.dashboard') }}" class="back-button">
        <span>←</span>
        <span>Kembali</span>
    </a>

    <!-- Page Title -->
    <h1 class="page-title">Laporan</h1>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('dosen.laporan') }}" id="filterForm" style="display: flex; gap: 12px; flex-wrap: wrap;">
            <button type="submit" name="period" value="all" class="filter-btn @if($period === 'all') active @endif">Semua Tugas</button>
            <button type="submit" name="period" value="bulan_ini" class="filter-btn @if($period === 'bulan_ini') active @endif">Bulan Ini</button>
            <button type="submit" name="period" value="tiga_bulan" class="filter-btn @if($period === 'tiga_bulan') active @endif">3 Bulan</button>
            <button type="submit" name="period" value="enam_bulan" class="filter-btn @if($period === 'enam_bulan') active @endif">6 Bulan</button>
        </form>
    </div>

    <!-- Tingkat Ketepatan Card -->
    <div class="report-card ketepatan-card">
        <div class="ketepatan-title">Tingkat Ketepatan</div>
        <div class="ketepatan-percentage">{{ $accuracyRate }}%</div>
        
        <div class="ketepatan-items">
            <div class="ketepatan-item">
                <span class="ketepatan-label">Tepat Waktu</span>
                <span class="ketepatan-percentage-value">{{ $breakdown['on_time_percentage'] }}%</span>
            </div>
            <div class="ketepatan-item">
                <span class="ketepatan-label">Terlambat</span>
                <span class="ketepatan-percentage-value">{{ $breakdown['late_percentage'] }}%</span>
            </div>
            <div class="ketepatan-item">
                <span class="ketepatan-label">Tidak Dikumpulkan</span>
                <span class="ketepatan-percentage-value">{{ $breakdown['not_submitted_percentage'] }}%</span>
            </div>
        </div>
    </div>

    <!-- Grafik Tren Card -->
    <div class="report-card grafik-card">
        <div class="grafik-title">Grafik Tren</div>
        
        <div style="position: relative; padding-left: 50px;">
            <div class="y-axis">
                <div class="y-axis-label" style="bottom: 200px;">100%</div>
                <div class="y-axis-label" style="bottom: 100px;">50%</div>
                <div class="y-axis-label" style="bottom: 0;">0%</div>
            </div>

            <div class="grafik-container">
                @forelse($monthlyData as $data)
                    <!-- {{ $data['month'] }} Bar -->
                    <div class="bar-group">
                        <div class="bar" style="height: {{ ($data['accuracy'] / 100) * 200 }}px;" title="Akurasi {{ $data['accuracy'] }}%"></div>
                        <div class="bar-label">{{ $data['month'] }}</div>
                    </div>
                @empty
                    <div style="text-align: center; width: 100%; padding: 40px 0; color: #999;">
                        <p>Belum ada data laporan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-value">{{ $totalTasks }}</div>
            <div class="stat-label">Total Tugas</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $completedOnTime }}</div>
            <div class="stat-label">Selesai Tepat</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $completedLate }}</div>
            <div class="stat-label">Terlambat</div>
        </div>
    </div>
</div>
@endsection
