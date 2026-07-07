<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Event;
use App\Models\Testimonial;
use App\Models\Offer;
use App\Models\Blog;
use App\Models\GalleryItem;
use App\Models\Enquiry;
use App\Models\Faq;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'counts' => [
                'doctors' => Doctor::count(),
                'services' => Service::count(),
                'events' => Event::count(),
                'testimonials' => Testimonial::count(),
                'offers' => Offer::count(),
                'blogs' => Blog::count(),
                'gallery' => GalleryItem::count(),
                'faqs' => Faq::count(),
                'enquiries' => Enquiry::count(),
                'new_enquiries' => Enquiry::where('status', 'new')->count(),
            ],
            'latestEnquiries' => Enquiry::latest()->take(6)->get(),
        ]);
    }
}
