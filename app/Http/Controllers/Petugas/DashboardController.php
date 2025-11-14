<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Classroom;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role.petugas');
    }

    public function index()
    {
        // Menghitung data untuk dashboard
        $totalSiswa = Student::count();
        $hadirHariIni = Attendance::whereDate('date', now()->toDateString())->count();
        $totalKelas = Classroom::count();

        return view('petugas.dashboard', compact('totalSiswa', 'hadirHariIni', 'totalKelas'));
    }
}