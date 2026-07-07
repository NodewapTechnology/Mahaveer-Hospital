@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / <a href="{{ route('offers') }}">Offers</a> / {{ $offer->title }}</div>
    </div>
</section>
<section class="section">
    <div class="container-x" style="max-width:900px;margin:0 auto;">
        @if($offer->image)
            <img src="{{ $offer->image }}" alt="{{ $offer->title }}" style="width:100%;border-radius:var(--radius-lg);margin-bottom:2rem;">
        @endif
        @if($offer->badge)<span class="badge-mh">{{ $offer->badge }}</span>@endif
        <h1 style="margin-top:1rem;">{{ $offer->title }}</h1>
        @if($offer->discount_label)<div style="font-family:var(--font-display);font-size:2.5rem;color:var(--c-accent);font-weight:700;margin:1rem 0;">{{ $offer->discount_label }}</div>@endif
        <p style="font-size:1.1rem;color:var(--c-ink-soft);">{{ $offer->short_description }}</p>
        <div style="margin-top:1.5rem;font-size:1.02rem;line-height:1.8;">{!! $offer->description !!}</div>
        @if($offer->valid_from || $offer->valid_until)
            <div style="margin-top:1.5rem;color:var(--c-muted);">Valid: {{ optional($offer->valid_from)->format('d M Y') }} — {{ optional($offer->valid_until)->format('d M Y') }}</div>
        @endif
        <div style="margin-top:2rem;">
            <a href="{{ route('contact') }}" class="btn-mh btn-primary-mh"><i class="fas fa-calendar-plus"></i> Enquire About This Offer</a>
        </div>
    </div>
</section>
@endsection
