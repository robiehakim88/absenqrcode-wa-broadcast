<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Classroom;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $classrooms = Classroom::all();

        if ($classrooms->isEmpty()) {
            $this->command->warn('Tidak ada kelas ditemukan. Jalankan ClassroomSeeder terlebih dahulu.');
            return;
        }

        foreach ($classrooms as $classroom) {
            $studentCount = rand(25, 35);
            
            // Cari NIS terakhir di kelas ini untuk memulai nomor urut
            // (Ini akan selalu 0 saat migrate:fresh, tapi aman untuk dijalankan berkali-kali)
            $lastStudent = $classroom->students()->orderBy('nis', 'desc')->first();
            $lastNumber = $lastStudent ? (int)substr($lastStudent->nis, -3) : 0;

            for ($i = 1; $i <= $studentCount; $i++) {
                $newNumber = str_pad($lastNumber + $i, 3, '0', STR_PAD_LEFT);
                $nis = $this->generateNis($classroom, $newNumber);

                Student::factory()->create([
                    'classroom_id' => $classroom->id,
                    'nis' => $nis,
                ]);
            }
        }
    }

    /**
     * Helper untuk membuat format NIS
     */
    private function generateNis(Classroom $classroom, $number)
    {
        $year = substr($classroom->academicYear->name, 0, 2); // '24'
        $majorCode = $this->getMajorCode($classroom->name);  // '01'
        return $year . $majorCode . $number;
    }

    private function getMajorCode($className)
    {
        if (strpos($className, 'RPL') !== false) return '01';
        if (strpos($className, 'TKJ') !== false) return '02';
        if (strpos($className, 'MM') !== false) return '03';
        return '00';
    }
}