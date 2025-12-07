<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('dosen.dashboard');
    }

    public function reminder()
    {
        return view('dosen.reminder');
    }

    public function sendReminder(Request $request)
    {
        // TODO: Implementasi send reminder
        return back()->with('success', 'Reminder berhasil dikirim');
    }

    public function laporan()
    {
        return view('dosen.laporan');
    }

    public function profile()
    {
        return view('dosen.profile');
    }
}
