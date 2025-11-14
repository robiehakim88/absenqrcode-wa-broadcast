<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Models\AcademicYear;
use App\Models\User;

class ClassroomSeeder extends Seeder
{
    public function run()
    {
        $activeYear = AcademicYear::where('is_active', true)->first();
        $teachers = User::where('role', 'wali_kelas')->get();

        if (!$activeYear || $teachers->isEmpty()) {
            $this->command->warn('Pastikan AcademicYearSeeder dan UserSeeder dijalankan terlebih dahulu.');
            return;
        }

        $classrooms = [
            ['name' => 'X RPL 1', 'teacher_id' => $teachers->get(0)->id],
            ['name' => 'X RPL 2', 'teacher_id' => $teachers->get(1)->id],
            ['name' => 'XI TKJ 1', 'teacher_id' => $teachers->get(2)->id],
            ['name' => 'XI TKJ 2', 'teacher_id' => $teachers->get(0)->id],
            ['name' => 'XII MM 1', 'teacher_id' => $teachers->get(1)->id],
        ];

        foreach ($classrooms as $classroom) {
            Classroom::create([
                'name' => $classroom['name'],
                'academic_year_id' => $activeYear->id,
                'teacher_id' => $classroom['teacher_id'],
            ]);
        }
    }
}