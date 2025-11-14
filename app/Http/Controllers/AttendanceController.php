<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Attendance;
use App\Jobs\SendWhatsappNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role.petugas');
    }

    public function scan()
    {
        return view('petugas.attendances.scan');
    }

    public function processScan(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::find($request->student_id);
        $today = Carbon::now()->toDateString();

        // Cek apakah siswa sudah absen hari ini
        $existingAttendance = Attendance::where('student_id', $student->id)
                                        ->where('date', $today)
                                        ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa ' . $student->name . ' sudah melakukan absensi hari ini.'
            ]);
        }

        // Buat record absensi baru
        Attendance::create([
            'student_id' => $student->id,
            'date' => $today,
            'time_in' => Carbon::now()->toTimeString(),
            'status' => 'hadir',
        ]);

        // Kirim notifikasi WhatsApp (asumsikan job sudah dibuat)
        $message = "Halo Bapak/Ibu orang tua dari *{$student->name}*, kami beritahukan bahwa anak Anda telah tiba di sekolah pada pukul " . Carbon::now()->format('H:i') . ". Terima kasih.";
        SendWhatsappNotification::dispatch($student->parent_phone, $message);

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil untuk ' . $student->name . '.',
            'student_name' => $student->name
        ]);
    }
}