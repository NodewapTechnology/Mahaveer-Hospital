@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / <a href="{{ route('services') }}">Services</a> / {{ $service->name }}</div>
        <h1 style="margin-top:1rem;">{{ $service->name }}</h1>
        <p>{{ $service->short_description }}</p>
    </div>
</section>

<section class="section">
    <div class="container-x" style="max-width:900px;margin:0 auto;">
        @if($service->image)
            <img src="{{ asset($service->image) }}" alt="{{ $service->name }}" style="width:100%;border-radius:var(--radius-lg);margin-bottom:2rem;">
        @endif
        <div style="font-size:1.05rem;line-height:1.8;">{!! $service->description !!}</div>

        @if(!empty($service->features))
            <h3 style="margin-top:2rem;">What's Included</h3>
            <ul style="list-style:none;padding:0;margin-top:1rem;">
                @foreach($service->features as $f)
                    <li style="padding:.6rem 0;border-bottom:1px solid var(--c-line-soft);"><i class="fas fa-check" style="color:var(--c-accent);margin-right:.6rem;"></i>{{ $f }}</li>
                @endforeach
            </ul>
        @endif

        <div style="margin-top:2rem;">
            <a href="{{ route('contact') }}" class="btn-mh btn-primary-mh"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
        </div>
    </div>
</section>
@endsection
