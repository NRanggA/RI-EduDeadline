@extends('layouts.app')

@section('title', 'Upload Bab Terbaru')

@section('content')
<div class="flex flex-col items-center justify-start pt-4 pb-8 bg-gradient-to-b from-white to-gray-50 min-h-screen">

    <!-- Main Content Container -->
    <div class="w-full max-w-md mx-auto px-4 space-y-6">
        
        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('mahasiswa.skripsi') }}" class="text-gray-600 hover:text-gray-900">
                <span class="material-icons">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Upload Bab Terbaru</h1>
        </div>

        <!-- Form Section -->
        <form action="{{ route('mahasiswa.upload-chapter') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- BAB Selection -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
                <label for="chapter" class="block text-sm text-gray-500 font-semibold mb-3">BAB yang diupload:</label>
                
                <div class="space-y-2">
                    @foreach($defaultChapters as $chapterKey => $chapterName)
                        @php
                            $isSubmitted = $chapters->firstWhere('chapter', $chapterKey);
                            $latestSubmission = $submissions->firstWhere('chapter', $chapterKey);
                        @endphp
                        <label class="flex items-center p-3 rounded-lg border-2 cursor-pointer transition {{ $loop->first ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}" onclick="selectChapter('{{ $chapterKey }}', '{{ $chapterName }}')">
                            <input type="radio" name="chapter" value="{{ $chapterKey }}" class="w-5 h-5 text-blue-600" {{ $loop->first ? 'checked' : '' }} required onchange="updateChapterInfo('{{ $chapterKey }}', '{{ $chapterName }}')">
                            <div class="ml-3 flex-1">
                                <p class="font-semibold text-gray-800">{{ $chapterKey }}</p>
                                <p class="text-xs text-gray-500">{{ $chapterName }}</p>
                            </div>
                            @if($latestSubmission)
                                <span class="text-xs font-semibold {{ $latestSubmission->status === 'approved' ? 'text-green-600' : 'text-amber-600' }}">
                                    v{{ $latestSubmission->version }}
                                </span>
                            @endif
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Chapter Title -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
                <label for="title" class="block text-sm text-gray-500 font-semibold mb-2">Judul Bab</label>
                <input type="text" id="title" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Pendahuluan" value="{{ old('title') }}" required>
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Upload -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
                <label for="file" class="block text-sm text-gray-500 font-semibold mb-3">Upload File:</label>
                
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition cursor-pointer" id="uploadArea" onclick="document.getElementById('file').click()">
                    <div class="space-y-2">
                        <p class="text-2xl">📄</p>
                        <p class="text-gray-600 font-medium">Drag & drop file atau klik</p>
                        <p class="text-xs text-gray-500">Format: PDF, DOC, DOCX (Max 10 MB)</p>
                    </div>
                    <input type="file" id="file" name="file" class="hidden" accept=".pdf,.doc,.docx" required onchange="handleFileSelect()">
                </div>

                <!-- File Name Display -->
                <div id="fileInfo" class="mt-3 hidden">
                    <div class="flex items-center gap-2 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <span class="text-lg">✓</span>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-800" id="fileName"></p>
                            <p class="text-xs text-gray-600" id="fileSize"></p>
                        </div>
                    </div>
                </div>

                @error('file')
                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan (Optional) -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
                <label for="description" class="block text-sm text-gray-500 font-semibold mb-2">Catatan untuk Pembimbing (Opsional)</label>
                <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tuliskan catatan atau revisi yang sudah Anda lakukan...">{{ old('description') }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="space-y-2">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 shadow-sm flex items-center justify-center gap-2">
                    <span class="material-icons text-sm">upload</span>
                    <span>Upload</span>
                </button>
                <a href="{{ route('mahasiswa.skripsi') }}" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200 text-center">
                    Batal
                </a>
            </div>

        </form>

        <!-- Info Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-blue-800">
                <strong>💡 Tips:</strong> Pastikan file Anda sudah dikerjakan dengan baik sebelum diupload. File yang sudah diupload dapat dievaluasi oleh pembimbing Anda.
            </p>
        </div>

    </div>
</div>

<script>
    function selectChapter(chapter, name) {
        document.getElementById('title').value = name;
    }

    function updateChapterInfo(chapter, name) {
        document.getElementById('title').value = name;
    }

    function handleFileSelect() {
        const fileInput = document.getElementById('file');
        const file = fileInput.files[0];
        
        if (file) {
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
            fileInfo.classList.remove('hidden');
        }
    }

    // Drag and drop
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('file');

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = '#3b82f6';
        uploadArea.style.backgroundColor = '#eff6ff';
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.style.borderColor = '#d1d5db';
        uploadArea.style.backgroundColor = 'white';
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.style.borderColor = '#d1d5db';
        uploadArea.style.backgroundColor = 'white';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect();
        }
    });
</script>

@endsection
