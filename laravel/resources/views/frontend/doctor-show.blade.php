@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / <a href="{{ route('doctors') }}">Doctors</a> / {{ $doctor->name }}</div>
    </div>
</section>

<section class="section">
    <div class="container-x">
        <div style="display:grid;grid-template-columns:1fr;gap:2rem;" class="doctor-show-grid">
            <div>
                <div class="doctor-featured" data-testid="doctor-profile-{{ $doctor->slug }}">
                    <div class="photo">
                        @if($doctor->photo)
                            <img src="{{ asset($doctor->photo) }}" alt="{{ $doctor->name }}">
                        @endif
                    </div>
                    <div class="details">
                        <div class="role">{{ $doctor->designation }}</div>
                        <h1 class="name">{{ $doctor->name }}</h1>
                        <span class="credentials"><i class="fas fa-graduation-cap" style="color:var(--c-accent);"></i> {{ $doctor->qualification }}</span>

                        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1rem;margin-top:1.5rem;">
                            @if($doctor->experience)
                                <div><div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.16em;color:var(--c-muted);">Experience</div><div style="margin-top:.25rem;font-weight:600;">{{ $doctor->experience }}</div></div>
                            @endif
                            @if($doctor->specialization)
                                <div><div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.16em;color:var(--c-muted);">Specialization</div><div style="margin-top:.25rem;font-weight:600;">{{ $doctor->specialization }}</div></div>
                            @endif
                            @if($doctor->available_timing)
                                <div style="grid-column:1/-1;"><div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.16em;color:var(--c-muted);">OPD Timing</div><div style="margin-top:.25rem;font-weight:600;">{{ $doctor->available_timing }}</div></div>
                            @endif
                        </div>

                        <p style="margin-top:1.5rem;">{{ $doctor->description }}</p>

                        <div style="display:flex;gap:.6rem;flex-wrap:wrap;margin-top:1.5rem;">
                            <a href="{{ route('contact') }}" class="btn-mh btn-primary-mh"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
                            @if($doctor->contact_phone)
                                <a href="tel:{{ $doctor->contact_phone }}" class="btn-mh btn-outline-mh"><i class="fas fa-phone"></i> {{ $doctor->contact_phone }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
