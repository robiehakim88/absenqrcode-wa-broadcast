@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="container">
    <h1>Dashboard Petugas</h1>
    <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong> (Petugas)</p>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Siswa</h5>
                    <h2>{{ $totalSiswa }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Hadir Hari Ini</h5>
                    <h2>{{ $hadirHariIni }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Kelas</h5>
                    <h2>{{ $totalKelas }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Scan Absen</h5>
                    <a href="{{ route('petugas.scan') }}" class="btn btn-light">Buka Halaman</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection