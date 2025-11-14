<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role.admin');
    }

    // Menampilkan daftar sekolah (biasanya hanya satu)
    public function index()
    {
        $school = School::first();
        if ($school) {
            return redirect()->route('admin.schools.edit', $school->id);
        }
        return redirect()->route('admin.schools.create');
    }

    // Menampilkan form untuk membuat sekolah baru
    public function create()
    {
        return view('admin.schools.create');
    }

    // Menyimpan data sekolah baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        School::create($data);

        return redirect()->route('admin.schools.index')->with('success', 'Data sekolah berhasil disimpan.');
    }

    // Menampilkan form untuk edit sekolah
    public function edit(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    // Memperbarui data sekolah
    public function update(Request $request, School $school)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($school->logo) {
                \Storage::disk('public')->delete($school->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        $school->update($data);

        return redirect()->route('admin.schools.index')->with('success', 'Data sekolah berhasil diperbarui.');
    }
}