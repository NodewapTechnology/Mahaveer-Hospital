@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / Events</div>
        <span class="overline">Health Camps & Events</span>
        <h1 style="margin-top:1rem;">Community wellness — hosted with heart.</h1>
        <p>Free camps, awareness talks and workshops open to all.</p>
    </div>
</section>

<section class="section">
    <div class="container-x">
        <div class="grid-3" data-testid="events-grid">
            @forelse($events as $e)
                <a href="{{ route('events.show', $e->slug) }}" class="event-card reveal" style="text-decoration:none;color:inherit;" data-testid="event-{{ $e->slug }}">
                    @if($e->image)
                        <div class="thumb"><img src="{{ $e->image }}" alt="{{ $e->title }}"></div>
                    @endif
                    <div class="body">
                        <div class="event-date"><i class="fas fa-calendar"></i> {{ $e->event_date->format('D, d M Y') }} {{ $e->event_time }}</div>
                        <h3>{{ $e->title }}</h3>
                        <div class="venue"><i class="fas fa-location-dot"></i> {{ $e->venue }}</div>
                        <p class="desc">{{ $e->short_description }}</p>
                    </div>
                </a>
            @empty
                <p>No events scheduled currently.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
