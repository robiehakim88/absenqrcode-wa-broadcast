@extends('layouts.app')
@section('title', 'Tambah Tahun Ajaran')
@section('content')
<div class="container">
    <h1>{{ isset($academicYear) ? 'Edit' : 'Tambah' }} Tahun Ajaran</h1>
    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <form action="{{ isset($academicYear) ? route('admin.academic-years.update', $academicYear->id) : route('admin.academic-years.store') }}" method="POST">
                @csrf
                @if(isset($academicYear)) @method('PUT') @endif
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Tahun Ajaran</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $academicYear->name ?? '') }}" placeholder="Contoh: 2024/2025" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" name="is_active" value="1" {{ old('is_active', $academicYear->is_active ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Tetapkan sebagai Tahun Ajaran Aktif</label>
                    @error('is_active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection