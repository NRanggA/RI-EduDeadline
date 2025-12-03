<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EduDeadline') - Manajemen Deadline Mahasiswa</title>
    
    <!-- Tailwind CSS CDN (Production: compile dengan Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        /* Container untuk responsiveness */
        .app-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Card dengan shadow modern */
        .card-modern {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .card-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }
        
        /* HMW 1 - EMPHASIS: Urgent Card */
        .card-urgent {
            border: 4px solid #ff4757;
            background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
            box-shadow: 0 6px 25px rgba(255, 71, 87, 0.3);
        }
        
        /* HMW 2 - CONTRAST: Status Colors */
        .status-green { 
            background: #2ed573; 
            color: white; 
            padding: 6px 14px; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .status-red { 
            background: #ff4757; 
            color: white; 
            padding: 6px 14px; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .status-orange { 
            background: #ffa502; 
            color: white; 
            padding: 6px 14px; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        /* HMW 4 - PROXIMITY: Spacing */
        .mk-card {
            margin-bottom: 28px; /* Jarak BESAR antar grup */
        }
        
        .task-item {
            padding: 10px 0; /* Jarak KECIL dalam grup */
        }
        
        /* HMW 5 - WHITE SPACE: Spacious Layout */
        .spacious-layout {
            padding: 50px 30px;
        }
        
        .spacious-section {
            margin-bottom: 50px;
        }
        
        /* Gradient Button */
        .btn-gradient {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            .app-container {
                padding: 15px;
            }
            
            .card-modern {
                border-radius: 12px;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Header/Navbar (jika login) -->
    @auth
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <span class="text-3xl">📚</span>
                    <a href="{{ Auth::user()->role === 'dosen' ? route('dosen.dashboard') : route('mahasiswa.dashboard') }}" class="text-xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                        EduDeadline
                    </a>
                </div>
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-6">
                    @if(Auth::user()->role === 'dosen')
                        <a href="{{ route('dosen.dashboard') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">🏠 Dashboard</a>
                        <a href="#" class="text-gray-700 hover:text-purple-600 font-medium transition">📢 Reminder</a>
                        <a href="#" class="text-gray-700 hover:text-purple-600 font-medium transition">📊 Laporan</a>
                    @else
                        <a href="{{ route('mahasiswa.dashboard') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">🏠 Dashboard</a>
                        <a href="{{ route('mahasiswa.per-mk') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">📚 Per MK</a>
                        <a href="{{ route('mahasiswa.kalender') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">📅 Kalender</a>
                        <a href="{{ route('mahasiswa.skripsi') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">📝 Skripsi</a>
                        <a href="{{ route('mahasiswa.timeline') }}" class="text-gray-700 hover:text-purple-600 font-medium transition">⏱️ Timeline</a>
                    @endif
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-gray-700 hover:text-purple-600 font-medium">
                            <span>👤</span>
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 rounded-t-lg">Profile</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 rounded-b-lg">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
            @if(Auth::user()->role === 'dosen')
                <a href="{{ route('dosen.dashboard') }}" class="block px-4 py-3 text-gray-700 hover:bg-purple-50">🏠 Dashboard</a>
                <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-purple-50">📢 Reminder</a>
                <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-purple-50">📊 Laporan</a>
            @else
                <a href="{{ route('mahasiswa.dashboard') }}" class="block px-4 py-3 text-gray-700 hover:bg-purple-50">🏠 Dashboard</a>
                <a href="{{ route('mahasiswa.per-mk') }}" class="block px-4 py-3 text-gray-700 hover:bg-purple-50">📚 Per MK</a>
                <a href="{{ route('mahasiswa.kalender') }}" class="block px-4 py-3 text-gray-700 hover:bg-purple-50">📅 Kalender</a>
                <a href="{{ route('mahasiswa.skripsi') }}" class="block px-4 py-3 text-gray-700 hover:bg-purple-50">📝 Skripsi</a>
                <a href="{{ route('mahasiswa.timeline') }}" class="block px-4 py-3 text-gray-700 hover:bg-purple-50">⏱️ Timeline</a>
            @endif
            <form action="{{ route('logout') }}" method="POST" class="border-t">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50">Logout</button>
            </form>
        </div>
    </nav>
    @endauth
    
    <!-- Main Content -->
    <main class="app-container py-8">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-white/10 backdrop-blur-lg mt-12 py-6 text-white text-center">
        <p>&copy; 2024 EduDeadline - Facthur Rahman & Perdana Nauratsu Rangga W</p>
        <p class="text-sm mt-2 opacity-80">Universitas Muhammadiyah Malang</p>
    </footer>
    
    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobileMenu');
            const button = event.target.closest('button');
            if (!button && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>