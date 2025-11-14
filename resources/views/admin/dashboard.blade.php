@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h1>Dashboard Admin</h1>
    <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong> (Admin)</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-building display-4 text-primary"></i>
                    <h5 class="card-title mt-2">Pengaturan Sekolah</h5>
                    <p class="card-text">Kelola nama, alamat, dan logo sekolah.</p>
                    <a href="{{ route('admin.schools.index') }}" class="btn btn-primary">Kelola</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-event display-4 text-success"></i>
                    <h5 class="card-title mt-2">Tahun Ajaran</h5>
                    <p class="card-text">Atur tahun ajaran yang sedang aktif.</p>
                    <a href="{{ route('admin.academic-years.index') }}" class="btn btn-success">Kelola</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill display-4 text-info"></i>
                    <h5 class="card-title mt-2">Pengguna</h5>
                    <p class="card-text">Kelola akun Petugas dan Wali Kelas.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-info">Kelola</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection