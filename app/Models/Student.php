<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'name',
        'classroom_id',
        'parent_phone',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Relasi untuk mendapatkan kehadiran hari ini
    public function todayAttendance()
    {
        return $this->hasOne(Attendance::class)->where('date', now()->toDateString());
    }
}