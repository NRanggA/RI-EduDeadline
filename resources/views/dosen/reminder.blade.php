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

    @if($courses->isEmpty())
        <div style="text-align: center; padding: 40px 20px; color: #999;">
            <p>Anda belum mengampu mata kuliah apapun atau tidak ada tugas yang dibuat</p>
        </div>
    @else
        <!-- Reminder Form -->
        <form action="{{ route('dosen.reminder.send') }}" method="POST">
            @csrf

            <!-- Section 1: Pilih Mata Kuliah dan Tugas -->
            <div class="reminder-card">
                <label class="reminder-label">Pilih Mata Kuliah:</label>
                <div class="input-group">
                    <select name="course_id" class="input-field" required id="course_select">
                        <option value="">-- Pilih Mata Kuliah --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }} ({{ $course->code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('course_id')
                    <span style="color: #ff4757; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Task Selection Info -->
            <div class="reminder-card" id="task_info" style="display: none; background: #f0f9ff; border: 1px solid #667eea;">
                <label class="reminder-label">Tugas-tugas pada mata kuliah ini:</label>
                <div id="task_list" style="max-height: 200px; overflow-y: auto;"></div>
            </div>

            <!-- Section 2: Kirim reminder ke -->
            <div class="reminder-card">
                <label class="reminder-label">Kirim reminder ke:</label>
                <div class="checkbox-group">
                    <label class="checkbox-item">
                        <input type="radio" name="recipient_type" value="semua_mahasiswa" {{ old('recipient_type') == 'semua_mahasiswa' ? 'checked' : '' }} required>
                        <span class="checkbox-label">Semua Mahasiswa</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="radio" name="recipient_type" value="belum_mengumpulkan" {{ old('recipient_type') == 'belum_mengumpulkan' ? 'checked' : '' }}>
                        <span class="checkbox-label">Yang Belum Mengumpulkan</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="radio" name="recipient_type" value="terlambat" {{ old('recipient_type') == 'terlambat' ? 'checked' : '' }}>
                        <span class="checkbox-label">Yang Terlambat</span>
                    </label>
                </div>
                @error('recipient_type')
                    <span style="color: #ff4757; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Section 3: Judul Reminder -->
            <div class="reminder-card">
                <label class="reminder-label">Judul Reminder:</label>
                <div class="input-group">
                    <input 
                        type="text" 
                        name="title" 
                        class="input-field" 
                        placeholder="Pengingat Pengumpulan Tugas"
                        value="{{ old('title') }}"
                        required
                    >
                </div>
                @error('title')
                    <span style="color: #ff4757; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Section 4: Waktu Pengingat -->
            <div class="reminder-card">
                <label class="reminder-label">Jadwal Pengingat (opsional):</label>
                <div class="input-group">
                    <input 
                        type="datetime-local" 
                        name="waktu_pengingat" 
                        class="input-field" 
                        placeholder="Kapan reminder dikirim"
                        value="{{ old('waktu_pengingat') }}"
                    >
                </div>
                <p style="font-size: 12px; color: #999; margin-top: 8px;">Jika kosong, reminder akan dikirim langsung</p>
                @error('waktu_pengingat')
                    <span style="color: #ff4757; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Section 5: Template Pesan -->
            <div class="reminder-card">
                <label class="reminder-label">Template pesan:</label>
                <div class="input-group">
                    <textarea 
                        name="template_pesan" 
                        class="textarea-field" 
                        placeholder="Contoh: Halo, ini pengingat untuk tugas yang belum dikumpulkan. Silahkan segera mengumpulkan sebelum deadline."
                        required
                    >{{ old('template_pesan') }}</textarea>
                </div>
                @error('template_pesan')
                    <span style="color: #ff4757; font-size: 12px;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-reminder">
                Kirim Reminder
            </button>
        </form>

        <!-- Previous Reminders Section -->
        @if($previous_reminders->isNotEmpty())
            <div style="margin-top: 40px; border-top: 2px solid #e8e8e8; padding-top: 24px;">
                <h2 style="font-size: 18px; font-weight: 700; color: #333; margin-bottom: 16px;">Riwayat Reminder</h2>
                
                @foreach($previous_reminders as $reminder)
                    <div class="reminder-card" style="background: #f8f9ff;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <div style="font-weight: 700; color: #333; margin-bottom: 4px;">{{ $reminder->title }}</div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 4px;">
                                    Mata Kuliah: <strong>{{ $reminder->course->name }}</strong>
                                </div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 8px;">
                                    Tipe Penerima: 
                                    @if($reminder->recipient_type === 'all_students')
                                        Semua Mahasiswa
                                    @elseif($reminder->recipient_type === 'not_submitted')
                                        Yang Belum Mengumpulkan
                                    @else
                                        Yang Terlambat
                                    @endif
                                </div>
                                <div style="font-size: 11px; color: #999;">
                                    Dikirim: {{ $reminder->sent_at ? $reminder->sent_at->format('d M Y H:i') : 'Terjadwal' }}
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-weight: 700; color: #667eea; font-size: 14px;">
                                    {{ $reminder->recipients->count() }} Penerima
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    <script>
        // Show task info when course is selected
        document.getElementById('course_select').addEventListener('change', function() {
            const courseId = this.value;
            const taskInfo = document.getElementById('task_info');
            const taskList = document.getElementById('task_list');
            
            if (courseId) {
                taskInfo.style.display = 'block';
                // You could fetch tasks dynamically here via AJAX
                // For now, we'll show available tasks
                const courseTasks = @json($task_data);
                const selectedCourseTasks = courseTasks.filter(t => t.course.id == courseId);
                
                if (selectedCourseTasks.length > 0) {
                    taskList.innerHTML = selectedCourseTasks.map(task => `
                        <div style="padding: 8px 0; border-bottom: 1px solid #e0e7ff;">
                            <div style="font-weight: 600; font-size: 12px; color: #333;">${task.title}</div>
                            <div style="font-size: 11px; color: #666; margin-top: 2px;">
                                Deadline: ${new Date(task.deadline).toLocaleDateString('id-ID')} | 
                                Dikumpulkan: ${task.submitted}/${task.total_enrolled}
                            </div>
                        </div>
                    `).join('');
                } else {
                    taskList.innerHTML = '<p style="color: #999; font-size: 12px;">Tidak ada tugas untuk mata kuliah ini</p>';
                }
            } else {
                taskInfo.style.display = 'none';
            }
        });
    </script>
</div>
@endsection
