@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / Doctors</div>
        <span class="overline">Our Team</span>
        <h1 style="margin-top:1rem;">Meet our specialist doctors.</h1>
        <p>AIIMS-trained and evidence-driven — our physicians are chosen for both skill and warmth.</p>
    </div>
</section>

<section class="section">
    <div class="container-x">
        @if($featured)
            <div class="doctor-featured reveal" data-testid="doctor-featured">
                <div class="photo">
                    <span class="ribbon"><i class="fas fa-star"></i> Featured</span>
                    @if($featured->photo)
                        <img src="{{ asset($featured->photo) }}" alt="{{ $featured->name }}">
                    @endif
                </div>
                <div class="details">
                    <div class="role">{{ $featured->designation }}</div>
                    <h3 class="name">{{ $featured->name }}</h3>
                    <span class="credentials"><i class="fas fa-graduation-cap" style="color:var(--c-accent);"></i> {{ $featured->qualification }}</span>
                    <p>{{ $featured->description }}</p>
                    @if($featured->specialization)
                        <div style="margin-top:1.25rem;">
                            <div style="font-size:.72rem;letter-spacing:.2em;text-transform:uppercase;color:var(--c-muted);font-weight:600;">Specialization</div>
                            <div style="margin-top:.35rem;font-family:var(--font-display);font-size:1.1rem;">{{ $featured->specialization }}</div>
                        </div>
                    @endif
                    @if($featured->available_timing)
                        <div style="margin-top:1rem;color:var(--c-ink-soft);"><i class="fas fa-clock" style="color:var(--c-accent);margin-right:.4rem;"></i>{{ $featured->available_timing }}</div>
                    @endif
                    <div style="display:flex;gap:.6rem;flex-wrap:wrap;margin-top:1.5rem;">
                        <a href="{{ route('doctors.show', $featured->slug) }}" class="btn-mh btn-primary-mh"><i class="fas fa-user-doctor"></i> View Full Profile</a>
                        <a href="tel:{{ $featured->contact_phone ?? $siteContact?->phone_primary }}" class="btn-mh btn-outline-mh"><i class="fas fa-phone"></i> Call</a>
                    </div>
                </div>
            </div>
        @endif

        @if($others->count())
            <div class="grid-3 reveal" style="margin-top:3rem;">
                @foreach($others as $d)
                    <div class="doctor-card" data-testid="doctor-{{ $d->slug }}">
                        <div class="photo-wrap">
                            @if($d->photo)
                                <img src="{{ asset($d->photo) }}" alt="{{ $d->name }}">
                            @else
                                <div class="initial">{{ substr($d->name, strrpos($d->name, ' ') !== false ? strrpos($d->name, ' ') + 1 : 0, 1) }}</div>
                            @endif
                        </div>
                        <div class="body">
                            <div class="name">{{ $d->name }}</div>
                            <div class="role">{{ $d->designation }}</div>
                            <div class="qual"><i class="fas fa-graduation-cap"></i> {{ $d->qualification }}</div>
                            @if($d->specialization)
                                <div style="margin-top:.5rem;color:var(--c-ink-soft);font-size:.85rem;">{{ $d->specialization }}</div>
                            @endif
                            @if($d->available_timing)
                                <div class="timing"><i class="fas fa-clock"></i> {{ $d->available_timing }}</div>
                            @endif
                            <div style="margin-top:1rem;display:flex;gap:.4rem;">
                                <a href="{{ route('doctors.show', $d->slug) }}" class="btn-mh btn-outline-mh" style="padding:.5rem 1rem;font-size:.82rem;">Profile</a>
                                <a href="{{ route('contact') }}" class="btn-mh btn-primary-mh" style="padding:.5rem 1rem;font-size:.82rem;">Book</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
