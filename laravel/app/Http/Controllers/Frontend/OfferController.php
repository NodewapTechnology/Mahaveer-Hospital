<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index()
    {
        return view('frontend.offers', [
            'offers' => Offer::where('is_active', true)->latest()->get(),
        ]);
    }

    public function show($slug)
    {
        $offer = Offer::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('frontend.offer-show', ['offer' => $offer]);
    }
}
