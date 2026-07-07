<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;

class GalleryController extends Controller
{
    public function index()
    {
        return view('frontend.gallery', [
            'items' => GalleryItem::where('is_active', true)->orderBy('sort')->get(),
        ]);
    }
}
