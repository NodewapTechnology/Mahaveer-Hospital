<?php

namespace App\Http\Controllers\Admin;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DoctorController extends AdminBaseController
{
    public function index() { return view('admin.doctors.index', ['items' => Doctor::orderByDesc('is_featured')->orderBy('sort')->get()]); }
    public function create() { return view('admin.doctors.form', ['item' => new Doctor()]); }
    public function edit(Doctor $doctor) { return view('admin.doctors.form', ['item' => $doctor]); }
    public function store(Request $r) { return $this->save($r, new Doctor()); }
    public function update(Request $r, Doctor $doctor) { return $this->save($r, $doctor); }
    public function destroy(Doctor $doctor) { $doctor->delete(); return redirect()->route('admin.doctors.index')->with('success', 'Doctor removed'); }

    protected function save(Request $r, Doctor $d) {
        $data = $r->validate([
            'name' => 'required|string|max:150',
            'designation' => 'nullable|string|max:150',
            'qualification' => 'nullable|string|max:200',
            'experience' => 'nullable|string|max:100',
            'specialization' => 'nullable|string|max:200',
            'description' => 'nullable|string',
            'available_timing' => 'nullable|string|max:500',
            'contact_phone' => 'nullable|string|max:30',
            'contact_email' => 'nullable|email|max:150',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort' => 'nullable|integer',
            'photo' => 'nullable|image|max:5120',
        ]);
        $data['slug'] = $d->slug ?: Str::slug($data['name']);
        if (!$d->exists) {
            $base = $data['slug']; $i = 1;
            while (Doctor::where('slug', $data['slug'])->exists()) { $data['slug'] = $base . '-' . (++$i); }
        }
        $data['is_featured'] = $r->boolean('is_featured');
        $data['is_active'] = $r->boolean('is_active');
        $data['sort'] = (int) ($data['sort'] ?? 0);
        $data['photo'] = $this->handleImageUpload($r, 'photo', $d->photo, 'uploads/doctors');
        if ($data['is_featured']) {
            Doctor::where('id', '!=', $d->id ?? 0)->update(['is_featured' => false]);
        }
        $d->fill($data)->save();
        return redirect()->route('admin.doctors.index')->with('success', 'Doctor saved');
    }
}
