<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role.wali_kelas');
    }

    /**
     * Menampilkan dashboard dengan data kehadiran siswa.
     * Mendukung filter berdasarkan tanggal atau range tanggal.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $classroom = Classroom::where('teacher_id', $user->id)->first();
        $students = collect();

        // Ambil nilai filter dari request
        $filterDate = $request->input('filter_date');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($classroom) {
            $query = Student::where('classroom_id', $classroom->id)
                ->leftJoin('attendances', function ($join) use ($request) {
                    $join->on('attendances.student_id', '=', 'students.id');

                    // Logika filter
                    if ($request->filled('filter_date')) {
                        // Jika filter tanggal tunggal
                        $join->where('attendances.date', $request->input('filter_date'));
                    } elseif ($request->filled('start_date') && $request->filled('end_date')) {
                        // Jika filter range tanggal
                        $join->whereBetween('attendances.date', [$request->input('start_date'), $request->input('end_date')]);
                    } else {
                        // Default: tampilkan hari ini
                        $join->where('attendances.date', now()->toDateString());
                    }
                })
                ->select('students.*', 'attendances.time_in', 'attendances.status')
                ->orderBy('students.name');

            $students = $query->get();
        }

        // Kembalikan nilai filter ke view untuk mengisi form kembali
        return view('wali_kelas.dashboard', compact('classroom', 'students', 'filterDate', 'startDate', 'endDate'));
    }

    /**
     * Menampilkan halaman grafik kehadiran untuk siswa tertentu.
     */
    public function showAttendanceGraph(Student $student)
    {
        // **PENTING: Keamanan**
        // Pastikan wali kelas hanya bisa melihat grafik siswa di kelasnya sendiri
        if ($student->classroom->teacher_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Ambil semua data kehadiran siswa tersebut, diurutkan dari yang terlama
        $attendances = $student->attendances()->orderBy('date')->get();

        return view('wali_kelas.students.graph', compact('student', 'attendances'));
    }
}