<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return view('frontend.events', [
            'events' => Event::where('is_active', true)->orderBy('event_date')->get(),
        ]);
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('frontend.event-show', ['event' => $event]);
    }
}
