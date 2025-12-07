<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // TODO: Nanti ambil dari database
        $urgentCount = 3;
        $totalTasks = 12;
        $completedThisWeek = 8;

        return view('mahasiswa.dashboard', compact(
            'urgentCount',
            'totalTasks',
            'completedThisWeek'
        ));
    }

    public function skripsi()
    {
        return view('mahasiswa.skripsi');
    }

    public function timeline()
    {
        return view('mahasiswa.timeline');
    }

    public function focusMode()
    {
        return view('mahasiswa.focus-mode');
    }

    public function uploadProgress()
    {
        return view('mahasiswa.upload-progress');
    }

    public function profile()
    {
        return view('mahasiswa.profile');
    }
}
