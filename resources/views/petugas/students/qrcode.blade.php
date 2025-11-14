@extends('layouts.app')

@section('title', 'QR Code Siswa')

@section('content')
<div class="container text-center">
    <h1>QR Code untuk {{ $student->name }}</h1>
    <p class="text-muted">NIS: {{ $student->nis }} | Kelas: {{ $student->classroom->name }}</p>

    <div class="card mt-4 d-inline-block shadow-sm">
        <div class="card-body p-4">
            {!! $qrCode !!}
        </div>
    </div>

    <div class="mt-4">
        <button onclick="window.print()" class="btn btn-success"><i class="bi bi-printer me-2"></i>Cetak QR Code</button>
        <a href="{{ route('petugas.students.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection