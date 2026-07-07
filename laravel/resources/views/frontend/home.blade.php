@extends('frontend.layout')

@section('content')
@php
    $hero = $banners->first();
@endphp

{{-- HERO --}}
<section class="hero" data-testid="hero-section">
    <div class="container-x">
        <div class="hero-grid">
            <div class="reveal">
                @if($hero?->badge)
                    <span class="hero-badge" data-testid="hero-badge"><i class="fas fa-hand-holding-heart"></i> {{ $hero->badge }}</span>
                @endif
                <h1 class="hero-title" data-testid="hero-title">
                    {{ $hero?->title ?? 'Trusted care for every life stage' }}
                    @if($hero) <br><span class="accent">in Samastipur.</span> @endif
                </h1>
                <p class="hero-sub" data-testid="hero-subtitle">{{ $hero?->subtitle ?? 'AIIMS-trained surgeons, advanced technology, and warm, compassionate care.' }}</p>
                <div class="hero-cta">
                    <a href="{{ $hero?->cta_link ?? route('contact') }}" class="btn-mh btn-primary-mh" data-testid="hero-cta-book">
                        <i class="fas fa-calendar-check"></i> {{ $hero?->cta_text ?? 'Book Appointment' }}
                        <i class="fas fa-arrow-right" style="font-size:.75rem;"></i>
                    </a>
                    <a href="tel:{{ $siteContact?->phone_primary }}" class="btn-mh btn-outline-mh" data-testid="hero-cta-call">
                        <i class="fas fa-phone"></i> {{ $siteContact?->phone_primary ?? 'Call Now' }}
                    </a>
                </div>

                @if($about?->stats)
                    <div class="hero-stats" data-testid="hero-stats">
                        @foreach(array_slice($about->stats, 0, 3) as $i => $s)
                            <div data-testid="hero-stat-{{ $i }}">
                                <div class="value">{{ $s['value'] }}</div>
                                <div class="label">{{ $s['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="hero-visual reveal">
                <div class="hero-doctor-card" data-testid="hero-doctor-card">
                    @if($featuredDoctor?->photo)
                        <img src="{{ asset($featuredDoctor->photo) }}" alt="{{ $featuredDoctor->name }}">
                    @endif
                    <span class="emergency-pill">● 24/7 Emergency</span>
                    <div class="hero-doctor-overlay">
                        <div class="name">{{ $featuredDoctor?->name ?? 'Dr. Amardeep' }}</div>
                        <div class="cred">{{ $featuredDoctor?->qualification ?? 'MBBS, MS, FMAS' }}</div>
                        <div class="role">{{ $featuredDoctor?->designation ?? 'Senior Consultant' }}</div>
                    </div>
                    <div class="safe-badge">
                        <div class="icn"><i class="fas fa-shield-heart"></i></div>
                        <div>
                            <div class="title">100% Safe Care</div>
                            <div class="sub">NABH Standard Protocols</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- EMERGENCY --}}
<section class="section compact" data-testid="emergency-section">
    <div class="container-x">
        <div class="emergency-strip reveal">
            <div class="icon-wrap"><i class="fas fa-truck-medical"></i></div>
            <div>
                <h3>24×7 Emergency & Trauma Care</h3>
                <p>Round-the-clock ambulance, ICU-backed emergency team and rapid trauma response — always ready when seconds matter.</p>
            </div>
            <div class="phones">
                <a href="tel:{{ $siteContact?->emergency_phone }}" class="phone" data-testid="emergency-call-primary">
                    <i class="fas fa-phone"></i> {{ $siteContact?->emergency_phone ?? '+91 6287797276' }}
                </a>
                @if($siteContact?->phone_secondary)
                    <a href="tel:{{ $siteContact->phone_secondary }}" class="phone" data-testid="emergency-call-secondary">
                        <i class="fas fa-phone"></i> {{ $siteContact->phone_secondary }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- INTRO / ABOUT --}}
@if($about)
<section class="section" data-testid="about-section">
    <div class="container-x">
        <div style="display:grid;grid-template-columns:1fr;gap:3rem;align-items:start;" class="about-grid">
            <div class="reveal">
                <span class="overline">{{ $about->overline ?? 'About Us' }}</span>
                <h2 style="margin-top:1rem;">{{ $about->heading }}</h2>
            </div>
            <div class="reveal">
                <p style="font-size:1.05rem;">{{ $about->intro }}</p>
                <a href="{{ route('about') }}" class="btn-mh btn-outline-mh" style="margin-top:1.25rem;" data-testid="about-learn-more">
                    Learn more <i class="fas fa-arrow-right" style="font-size:.75rem;"></i>
                </a>
            </div>
        </div>
        @if($about->stats)
            <div class="grid-4 reveal" style="margin-top:3.5rem;">
                @foreach($about->stats as $s)
                    <div class="card-mh" style="text-align:left;">
                        <div class="value" style="font-family:var(--font-display);font-size:2.4rem;font-weight:700;color:var(--c-primary);line-height:1;">{{ $s['value'] }}</div>
                        <div style="margin-top:.65rem;font-size:.78rem;letter-spacing:.16em;text-transform:uppercase;color:var(--c-muted);">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endif

{{-- SERVICES --}}
@if($services->count())
<section class="section tinted" data-testid="services-section">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="overline">Our Specialities</span>
            <h2 style="margin-top:1rem;">World-class care, across specialities you can trust.</h2>
            <p>From advanced laparoscopic surgery to compassionate paediatric care — we bring metropolitan-standard expertise to North Bihar.</p>
        </div>
        <div class="grid-3">
            @foreach($services as $i => $s)
                <a href="{{ route('services.show', $s->slug) }}" class="service-card reveal" style="text-decoration:none;color:inherit;" data-testid="service-card-{{ $s->slug }}">
                    <div class="card-body">
                        <div class="num">0{{ $i + 1 }}</div>
                        <div class="icon-box"><i class="fas {{ $s->icon ?: 'fa-stethoscope' }}"></i></div>
                        <h3>{{ $s->name }}</h3>
                        <p class="desc">{{ $s->short_description }}</p>
                        @if(!empty($s->features))
                            <ul>
                                @foreach(array_slice($s->features, 0, 4) as $f)
                                    <li>{{ $f }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <span class="footer-link">Learn more <i class="fas fa-arrow-right" style="font-size:.7rem;"></i></span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- DOCTORS --}}
<section class="section" data-testid="doctors-section">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="overline">Our Doctors</span>
            <h2 style="margin-top:1rem;">Meet the healers behind Mahaveer Hospital.</h2>
            <p>AIIMS-trained specialists, warm bedside manners, and evidence-based practice — every single day.</p>
        </div>

        @if($featuredDoctor)
            <div class="doctor-featured reveal" data-testid="doctor-featured">
                <div class="photo">
                    <span class="ribbon"><i class="fas fa-sparkles"></i> Featured</span>
                    @if($featuredDoctor->photo)
                        <img src="{{ asset($featuredDoctor->photo) }}" alt="{{ $featuredDoctor->name }}">
                    @endif
                </div>
                <div class="details">
                    <div class="role">{{ $featuredDoctor->designation }}</div>
                    <h3 class="name">{{ $featuredDoctor->name }}</h3>
                    <span class="credentials"><i class="fas fa-graduation-cap" style="color:var(--c-accent);"></i> {{ $featuredDoctor->qualification }}</span>
                    <p>{{ $featuredDoctor->description }}</p>
                    <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:1.5rem;">
                        <a href="{{ route('doctors.show', $featuredDoctor->slug) }}" class="btn-mh btn-primary-mh" data-testid="featured-doctor-view">
                            View Profile <i class="fas fa-arrow-right" style="font-size:.75rem;"></i>
                        </a>
                        <a href="tel:{{ $featuredDoctor->contact_phone ?? $siteContact?->phone_primary }}" class="btn-mh btn-outline-mh">
                            <i class="fas fa-phone"></i> Call
                        </a>
                    </div>
                </div>
            </div>
        @endif

        @if($doctors->count())
            <div class="grid-4 reveal" style="margin-top:2.5rem;">
                @foreach($doctors as $d)
                    <div class="doctor-card" data-testid="doctor-card-{{ $d->slug }}">
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
                            @if($d->available_timing)
                                <div class="timing"><i class="fas fa-clock"></i> {{ $d->available_timing }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div style="text-align:center;margin-top:2.5rem;">
            <a href="{{ route('doctors') }}" class="btn-mh btn-outline-mh" data-testid="doctors-view-all">
                View All Doctors <i class="fas fa-arrow-right" style="font-size:.75rem;"></i>
            </a>
        </div>
    </div>
</section>

{{-- OFFERS PREVIEW --}}
@if($offers->count())
<section class="section tinted" data-testid="offers-section">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="overline">Latest Offers</span>
            <h2 style="margin-top:1rem;">Health packages made for every family.</h2>
        </div>
        <div class="grid-3">
            @foreach($offers as $o)
                <a href="{{ route('offers.show', $o->slug) }}" class="offer-card reveal" style="text-decoration:none;color:inherit;" data-testid="offer-card-{{ $o->slug }}">
                    @if($o->badge)<span class="badge-mh">{{ $o->badge }}</span>@endif
                    <h3>{{ $o->title }}</h3>
                    @if($o->discount_label)<div class="discount">{{ $o->discount_label }}</div>@endif
                    <p class="desc">{{ $o->short_description }}</p>
                    <div style="margin-top:auto;padding-top:1.5rem;color:var(--c-primary);font-weight:600;font-size:.9rem;">
                        View Details <i class="fas fa-arrow-right" style="font-size:.7rem;"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- TESTIMONIALS --}}
@if($testimonials->count())
<section class="section" data-testid="testimonials-section">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="overline">Patient Stories</span>
            <h2 style="margin-top:1rem;">Real voices from the families we care for.</h2>
        </div>
        <div class="grid-3">
            @foreach($testimonials->take(6) as $t)
                <div class="testimonial-card reveal" data-testid="testimonial-{{ $t->id }}">
                    <div class="quote-mark"><i class="fas fa-quote-left"></i></div>
                    <div class="stars">
                        @for($i = 0; $i < ($t->rating ?? 5); $i++)<i class="fas fa-star"></i>@endfor
                    </div>
                    <blockquote>"{{ $t->quote }}"</blockquote>
                    <div class="author">
                        <div class="name">{{ $t->name }}</div>
                        <div class="role">{{ $t->role }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- EVENTS + GALLERY GLIMPSE --}}
@if($events->count())
<section class="section tinted" data-testid="events-section">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="overline">Upcoming Events</span>
            <h2 style="margin-top:1rem;">Free camps, workshops & community care.</h2>
        </div>
        <div class="grid-3">
            @foreach($events as $e)
                <a href="{{ route('events.show', $e->slug) }}" class="event-card reveal" style="text-decoration:none;color:inherit;" data-testid="event-card-{{ $e->slug }}">
                    @if($e->image)
                        <div class="thumb"><img src="{{ $e->image }}" alt="{{ $e->title }}"></div>
                    @endif
                    <div class="body">
                        <div class="event-date"><i class="fas fa-calendar"></i> {{ $e->event_date->format('D, d M Y') }}</div>
                        <h3>{{ $e->title }}</h3>
                        <div class="venue"><i class="fas fa-location-dot"></i> {{ $e->venue }}</div>
                        <p class="desc">{{ $e->short_description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- GALLERY GLIMPSE --}}
@if($gallery->count())
<section class="section" data-testid="gallery-section">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="overline">Gallery</span>
            <h2 style="margin-top:1rem;">A glimpse inside Mahaveer Hospital.</h2>
        </div>
        <div class="gallery-grid reveal">
            @foreach($gallery as $g)
                <div class="gallery-item" data-gallery-item data-src="{{ $g->image }}" data-testid="gallery-item-{{ $g->id }}">
                    <img src="{{ $g->image }}" alt="{{ $g->title }}" loading="lazy">
                    <div class="overlay">
                        <div>
                            <div class="cat">{{ $g->category }}</div>
                            <div style="margin-top:.3rem;font-family:var(--font-display);">{{ $g->title }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:2rem;">
            <a href="{{ route('gallery') }}" class="btn-mh btn-outline-mh">View Full Gallery <i class="fas fa-arrow-right" style="font-size:.75rem;"></i></a>
        </div>
    </div>
</section>
@endif

{{-- FAQs --}}
@if($faqs->count())
<section class="section tinted" data-testid="faqs-section">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="overline">FAQ</span>
            <h2 style="margin-top:1rem;">Answers to what you're wondering.</h2>
        </div>
        <div class="reveal" style="max-width:900px;">
            @foreach($faqs as $f)
                <details class="faq-item" data-testid="faq-{{ $f->id }}">
                    <summary>{{ $f->question }}</summary>
                    <div class="answer">{{ $f->answer }}</div>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="section" data-testid="cta-section">
    <div class="container-x">
        <div class="reveal" style="background:linear-gradient(135deg, var(--c-primary), var(--c-primary-dark)); color:#fff; border-radius:var(--radius-lg); padding:4rem 2.5rem; text-align:center; position:relative; overflow:hidden;">
            <div style="position:absolute;top:-100px;right:-80px;width:280px;height:280px;background:radial-gradient(closest-side,var(--c-accent),transparent);opacity:.4;"></div>
            <div style="position:relative;">
                <h2 style="color:#fff;">Ready to take the first step towards better health?</h2>
                <p style="color:rgba(255,255,255,.85);margin-top:1rem;max-width:640px;margin-left:auto;margin-right:auto;">Book an appointment with our specialists today. Same-day slots available for urgent consultations.</p>
                <div style="margin-top:2rem;display:flex;gap:.75rem;flex-wrap:wrap;justify-content:center;">
                    <a href="{{ route('contact') }}" class="btn-mh btn-accent-mh" data-testid="cta-book"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
                    <a href="tel:{{ $siteContact?->phone_primary }}" class="btn-mh" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3);" data-testid="cta-call"><i class="fas fa-phone"></i> {{ $siteContact?->phone_primary }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
