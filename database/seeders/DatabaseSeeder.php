<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // 1. Buat Tahun Ajaran terlebih dahulu
            AcademicYearSeeder::class,
            // 2. Buat User (Admin, Petugas, Wali Kelas)
            UserSeeder::class,
            // 3. Buat Kelas (membutuhkan Tahun Ajaran dan User/Wali Kelas)
            ClassroomSeeder::class,
            // 4. Buat Siswa (membutuhkan Kelas)
            StudentSeeder::class,
        ]);
    }
}