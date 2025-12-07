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
        $validated = $request->validate([
            'recipient' => 'required|array|min:1',
            'recipient.*' => 'in:semua_mahasiswa,belum_mengumpulkan,terlambat',
            'waktu_pengingat' => 'required|string|max:255',
            'template_pesan' => 'required|string|max:1000',
        ], [
            'recipient.required' => 'Pilih setidaknya satu penerima reminder',
            'recipient.min' => 'Pilih setidaknya satu penerima reminder',
            'waktu_pengingat.required' => 'Waktu pengingat harus diisi',
            'template_pesan.required' => 'Template pesan harus diisi',
        ]);

        // TODO: Implementasi send reminder logic
        // - Simpan ke database
        // - Kirim notifikasi ke mahasiswa yang dituju

        return back()->with('success', 'Reminder berhasil diatur!');
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
