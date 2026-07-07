@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / Offers</div>
        <span class="overline">Health Packages</span>
        <h1 style="margin-top:1rem;">Care that fits every family.</h1>
        <p>Explore our seasonal offers and preventive health packages.</p>
    </div>
</section>
<section class="section">
    <div class="container-x">
        <div class="grid-3" data-testid="offers-grid">
            @forelse($offers as $o)
                <a href="{{ route('offers.show', $o->slug) }}" class="offer-card reveal" style="text-decoration:none;color:inherit;" data-testid="offer-{{ $o->slug }}">
                    @if($o->badge)<span class="badge-mh">{{ $o->badge }}</span>@endif
                    <h3>{{ $o->title }}</h3>
                    @if($o->discount_label)<div class="discount">{{ $o->discount_label }}</div>@endif
                    <p class="desc">{{ $o->short_description }}</p>
                    @if($o->valid_until)
                        <div style="margin-top:1rem;font-size:.78rem;color:var(--c-muted);">Valid till {{ $o->valid_until->format('d M Y') }}</div>
                    @endif
                    <div style="margin-top:auto;padding-top:1.5rem;color:var(--c-primary);font-weight:600;font-size:.9rem;">
                        View Details <i class="fas fa-arrow-right" style="font-size:.7rem;"></i>
                    </div>
                </a>
            @empty
                <p>No offers available now.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
