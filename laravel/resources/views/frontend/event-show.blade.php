@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / <a href="{{ route('events') }}">Events</a> / {{ $event->title }}</div>
    </div>
</section>
<section class="section">
    <div class="container-x" style="max-width:900px;margin:0 auto;">
        @if($event->image)
            <img src="{{ $event->image }}" alt="{{ $event->title }}" style="width:100%;border-radius:var(--radius-lg);margin-bottom:2rem;">
        @endif
        <div class="event-date"><i class="fas fa-calendar"></i> {{ $event->event_date->format('l, d F Y') }} {{ $event->event_time }}</div>
        <h1 style="margin-top:1rem;">{{ $event->title }}</h1>
        <div style="color:var(--c-muted);margin-top:.5rem;"><i class="fas fa-location-dot"></i> {{ $event->venue }}</div>
        <div style="margin-top:1.5rem;font-size:1.05rem;line-height:1.8;">{!! $event->description !!}</div>
        <div style="margin-top:2rem;">
            <a href="{{ route('contact') }}" class="btn-mh btn-primary-mh"><i class="fas fa-user-plus"></i> Register / Enquire</a>
        </div>
    </div>
</section>
@endsection
