<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role.petugas');
    }

    public function index()
    {
        $classrooms = Classroom::with('academicYear', 'teacher')->get();
        return view('petugas.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        $academicYears = AcademicYear::all();
        $teachers = User::where('role', 'wali_kelas')->get();
        return view('petugas.classrooms.create', compact('academicYears', 'teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        Classroom::create($request->all());

        return redirect()->route('petugas.classrooms.index')
                         ->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Classroom $classroom)
    {
        $academicYears = AcademicYear::all();
        $teachers = User::where('role', 'wali_kelas')->get();
        return view('petugas.classrooms.edit', compact('classroom', 'academicYears', 'teachers'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $classroom->update($request->all());

        return redirect()->route('petugas.classrooms.index')
                         ->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Classroom $classroom)
    {
        if ($classroom->students()->count() > 0) {
            return redirect()->route('petugas.classrooms.index')
                             ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa.');
        }

        $classroom->delete();
        return redirect()->route('petugas.classrooms.index')
                         ->with('success', 'Data kelas berhasil dihapus.');
    }
}