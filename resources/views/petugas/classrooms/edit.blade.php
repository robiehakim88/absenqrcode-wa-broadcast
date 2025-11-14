@extends('layouts.app')

@section('title', 'Edit Data Kelas')

@section('content')
<div class="container">
    <h1>Edit Data Kelas: {{ $classroom->name }}</h1>

    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <form action="{{ route('petugas.classrooms.update', $classroom->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $classroom->name) }}" placeholder="Contoh: X RPL 1" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="academic_year_id" class="form-label">Tahun Ajaran</label>
                            <select class="form-select @error('academic_year_id') is-invalid @enderror" id="academic_year_id" name="academic_year_id" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach ($academicYears as $year)
                                    <option value="{{ $year->id }}" {{ old('academic_year_id', $classroom->academic_year_id) == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                                @endforeach
                            </select>
                            @error('academic_year_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="teacher_id" class="form-label">Wali Kelas</label>
                            <select class="form-select @error('teacher_id') is-invalid @enderror" id="teacher_id" name="teacher_id">
                                <option value="">-- Pilih Wali Kelas (Opsional) --</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $classroom->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            @error('teacher_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <a href="{{ route('petugas.classrooms.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection