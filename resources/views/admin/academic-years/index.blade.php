@extends('layouts.app')
@section('title', 'Kelola Tahun Ajaran')
@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Kelola Tahun Ajaran</h1>
        <a href="{{ route('admin.academic-years.create') }}" class="btn btn-success"><i class="bi bi-plus-circle me-2"></i>Tambah Tahun Ajaran</a>
    </div>
    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Tahun Ajaran</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($academicYears as $year)
                        <tr>
                            <td>{{ $year->name }}</td>
                            <td>
                                @if($year->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.academic-years.edit', $year->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.academic-years.destroy', $year->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Belum ada data tahun ajaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection