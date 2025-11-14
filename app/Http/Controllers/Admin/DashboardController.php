<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role.admin');
    }

    public function index()
    {
        // Logika untuk dashboard admin bisa ditambahkan di sini
        // Misalnya mengambil data sekolah, tahun ajaran, dll.
        return view('admin.dashboard');
    }
}