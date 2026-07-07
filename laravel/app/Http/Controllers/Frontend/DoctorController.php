<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        return view('frontend.doctors', [
            'featured' => Doctor::where('is_active', true)->where('is_featured', true)->first(),
            'others' => Doctor::where('is_active', true)->where('is_featured', false)->orderBy('sort')->get(),
        ]);
    }

    public function show($slug)
    {
        $doctor = Doctor::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('frontend.doctor-show', ['doctor' => $doctor]);
    }
}
