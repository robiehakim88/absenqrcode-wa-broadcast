<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin Sekolah',
                'email' => 'admin@absensi.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Petugas Absensi',
                'email' => 'petugas@absensi.com',
                'password' => Hash::make('password'),
                'role' => 'petugas',
            ],
            [
                'name' => 'Ahmad Fadli, S.Pd',
                'email' => 'wali.kelas1@absensi.com',
                'password' => Hash::make('password'),
                'role' => 'wali_kelas',
            ],
            [
                'name' => 'Siti Nurhaliza, S.Pd',
                'email' => 'wali.kelas2@absensi.com',
                'password' => Hash::make('password'),
                'role' => 'wali_kelas',
            ],
            [
                'name' => 'Budi Santoso, S.Kom',
                'email' => 'wali.kelas3@absensi.com',
                'password' => Hash::make('password'),
                'role' => 'wali_kelas',
            ],
        ];

        DB::table('users')->insert($users);
    }
}