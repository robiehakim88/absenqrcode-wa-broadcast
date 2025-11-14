<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role.admin');
    }

    public function index()
    {
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        return view('admin.academic-years.index', compact('academicYears'));
    }

    public function create()
    {
        return view('admin.academic-years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:9|unique:academic_years,name',
            'is_active' => 'required|boolean',
        ]);

        // Jika tahun ajaran baru diset aktif, nonaktifkan yang lain
        if ($request->is_active) {
            AcademicYear::where('is_active', true)->update(['is_active' => false]);
        }

        AcademicYear::create($request->all());

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit(AcademicYear $academicYear)
    {
        return view('admin.academic-years.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $request->validate([
            'name' => 'required|string|max:9|unique:academic_years,name,' . $academicYear->id,
            'is_active' => 'required|boolean',
        ]);

        // Jika tahun ajaran ini diset aktif, nonaktifkan yang lain
        if ($request->is_active) {
            AcademicYear::where('is_active', true)->where('id', '!=', $academicYear->id)->update(['is_active' => false]);
        }

        $academicYear->update($request->all());

        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        // Cegah penghapusan tahun ajaran yang sedang aktif
        if ($academicYear->is_active) {
            return redirect()->route('admin.academic-years.index')->with('error', 'Tidak dapat menghapus tahun ajaran yang sedang aktif.');
        }
        
        // Cegah penghapusan jika ada kelas yang terkait
        if ($academicYear->classrooms()->count() > 0) {
            return redirect()->route('admin.academic-years.index')->with('error', 'Tidak dapat menghapus tahun ajaran karena masih ada kelas yang terkait.');
        }

        $academicYear->delete();
        return redirect()->route('admin.academic-years.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}