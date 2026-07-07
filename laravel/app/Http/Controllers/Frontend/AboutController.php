<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use App\Models\Doctor;

class AboutController extends Controller
{
    public function index()
    {
        return view('frontend.about', [
            'about' => AboutPage::first(),
            'doctors' => Doctor::where('is_active', true)->orderBy('sort')->take(4)->get(),
        ]);
    }
}
