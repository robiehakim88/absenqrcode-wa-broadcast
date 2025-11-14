@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="container">
    <h1>Dashboard Wali Kelas</h1>
    <p class="text-muted">Selamat datang, <strong>{{ Auth::user()->name }}</strong> (Wali Kelas {{ $classroom->name ?? '-' }})</p>

    {{-- Form Filter --}}
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Filter Kehadiran</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('wali_kelas.dashboard') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="filter_date" class="form-label">Filter Tanggal Tertentu</label>
                    <input type="date" class="form-control" id="filter_date" name="filter_date" value="{{ $filterDate ?? old('filter_date') }}">
                </div>
                <div class="col-md-2 align-self-end text-center">
                    <strong>ATAU</strong>
                </div>
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate ?? old('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate ?? old('end_date') }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-funnel me-2"></i>Terapkan Filter</button>
                    <a href="{{ route('wali_kelas.dashboard') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Rekap --}}
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Rekap Kehadiran Siswa</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jam Masuk</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->nis }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->time_in ?? '-' }}</td>
                            <td>
                                @if($student->status)
                                    <span class="badge bg-success">{{ $student->status }}</span>
                                @else
                                    <span class="badge bg-danger">Belum Absen</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('wali_kelas.students.attendance.graph', $student->id) }}" class="btn btn-sm btn-info" title="Lihat Grafik Kehadiran">
                                    <i class="bi bi-graph-up"></i> Grafik
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada siswa di kelas Anda atau kelas belum ditetapkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection