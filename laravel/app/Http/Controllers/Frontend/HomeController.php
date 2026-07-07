<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\AboutPage;
use App\Models\Service;
use App\Models\Doctor;
use App\Models\Testimonial;
use App\Models\Offer;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.home', [
            'banners' => Banner::where('is_active', true)->orderBy('sort')->get(),
            'about' => AboutPage::first(),
            'services' => Service::where('is_active', true)->orderBy('sort')->take(6)->get(),
            'featuredDoctor' => Doctor::where('is_active', true)->where('is_featured', true)->first(),
            'doctors' => Doctor::where('is_active', true)->where('is_featured', false)->orderBy('sort')->take(4)->get(),
            'testimonials' => Testimonial::where('is_active', true)->orderBy('sort')->take(6)->get(),
            'offers' => Offer::where('is_active', true)->latest()->take(3)->get(),
            'events' => Event::where('is_active', true)->orderBy('event_date')->take(3)->get(),
            'gallery' => GalleryItem::where('is_active', true)->orderBy('sort')->take(6)->get(),
            'faqs' => Faq::where('is_active', true)->orderBy('sort')->take(5)->get(),
        ]);
    }
}
