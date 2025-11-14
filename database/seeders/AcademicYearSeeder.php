<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicYear;

class AcademicYearSeeder extends Seeder
{
    public function run()
    {
        $years = [
            ['name' => '2023/2024', 'is_active' => false],
            ['name' => '2024/2025', 'is_active' => true], // Tahun ajaran aktif
        ];

        foreach ($years as $year) {
            AcademicYear::create($year);
        }
    }
}