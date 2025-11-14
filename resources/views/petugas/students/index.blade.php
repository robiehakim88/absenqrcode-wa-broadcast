@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Data Siswa</h1>
        <a href="{{ route('petugas.students.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Siswa</a>
    </div>

    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>No. HP Ortu</th>
                            <th class="text-center" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                        <tr>
                            <td>{{ $student->nis }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->classroom->name }}</td>
                            <td>{{ $student->parent_phone }}</td>
                            <td class="text-center">
                                <a href="{{ route('petugas.students.qrcode', $student->id) }}" class="btn btn-sm btn-info" title="Lihat QR Code"><i class="bi bi-qr-code"></i></a>
                                <a href="{{ route('petugas.students.edit', $student->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('petugas.students.destroy', $student->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data siswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection