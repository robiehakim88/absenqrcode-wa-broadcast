@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Data Kelas</h1>
        <a href="{{ route('petugas.classrooms.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Kelas</a>
    </div>

    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Wali Kelas</th>
                            <th class="text-center" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classrooms as $classroom)
                        <tr>
                            <td>{{ $classroom->name }}</td>
                            <td>{{ $classroom->academicYear->name }}</td>
                            <td>{{ $classroom->teacher?->name ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('petugas.classrooms.edit', $classroom->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('petugas.classrooms.destroy', $classroom->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data kelas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection