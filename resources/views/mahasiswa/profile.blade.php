@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-b from-white to-gray-50 px-4 py-8">
    
    <!-- Profile Card -->
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden">
        
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-6 flex items-center gap-3">
            <span class="material-icons text-white text-2xl">person</span>
            <h1 class="text-white text-2xl font-bold">Profile</h1>
        </div>
        
        <!-- Content Section -->
        <div class="p-8 space-y-6">
            
            <!-- Profile Avatar -->
            <div class="flex flex-col items-center">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <span class="material-icons text-white text-5xl">person</span>
                </div>
            </div>
            
            <!-- User Info -->
            <div class="text-center space-y-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h2>
                </div>
                
                <div class="space-y-2 text-sm text-gray-600">
                    <div>
                        <p class="text-gray-500 font-semibold">NIM</p>
                        <p class="text-gray-700 font-mono">{{ Auth::user()->nim ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-semibold">Email</p>
                        <p class="text-gray-700">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold text-lg py-3 px-4 rounded-xl transition transform hover:scale-105 active:scale-95 shadow-md">
                    KELUAR
                </button>
            </form>
            
        </div>
        
    </div>
    
</div>

@endsection
