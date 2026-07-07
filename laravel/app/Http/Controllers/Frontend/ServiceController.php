<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('frontend.services', [
            'services' => Service::where('is_active', true)->orderBy('sort')->get(),
        ]);
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('frontend.service-show', ['service' => $service]);
    }
}
