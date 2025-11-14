<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classroom;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role.petugas');
    }

    public function index()
    {
        // Mengambil semua siswa beserta data kelasnya untuk ditampilkan
        $students = Student::with('classroom')->get();
        return view('petugas.students.index', compact('students'));
    }

    public function create()
    {
        // Mengambil semua data kelas untuk dropdown
        $classrooms = Classroom::all();
        return view('petugas.students.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:students,nis',
            'name' => 'required|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'parent_phone' => 'required|string|max:15',
        ]);

        Student::create($request->all());

        return redirect()->route('petugas.students.index')
                         ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Student $student)
    {
        $classrooms = Classroom::all();
        return view('petugas.students.edit', compact('student', 'classrooms'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nis' => 'required|unique:students,nis,' . $student->id,
            'name' => 'required|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'parent_phone' => 'required|string|max:15',
        ]);

        $student->update($request->all());

        return redirect()->route('petugas.students.index')
                         ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('petugas.students.index')
                         ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function generateQrCode(Student $student)
    {
        // Data QR Code berisi URL untuk proses absensi
        $qrData = route('petugas.scan.process', ['student_id' => $student->id]);
        $qrCode = QrCode::size(200)->generate($qrData);

        return view('petugas.students.qrcode', compact('student', 'qrCode'));
    }
}