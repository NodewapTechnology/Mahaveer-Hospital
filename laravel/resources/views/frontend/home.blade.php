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
                <div class="hero-appt-card" data-testid="hero-appointment-card">
                    <span class="emergency-pill">● {{ \App\Helpers\I18n::ui('label.emergency') }}</span>

                    <div class="hero-appt-head">
                        <div class="mini-icon"><i class="fas fa-calendar-check"></i></div>
                        <div>
                            <div class="eyebrow" style="margin:0;color:var(--c-accent);">Quick Booking</div>
                            <h3 style="font-family:var(--f-display);font-size:1.55rem;margin-top:.3rem;line-height:1.05;">Book Your Appointment</h3>
                            <p style="font-size:.85rem;color:var(--c-muted);margin-top:.3rem;">Fill this form — we'll call to confirm within a few hours.</p>
                        </div>
                    </div>

                    @if(session('appointment_success'))
                        <div class="alert-mh alert-success-mh" data-testid="appt-success" style="margin-bottom:.9rem;">
                            <i class="fas fa-check-circle"></i> {{ session('appointment_success') }}
                        </div>
                    @endif
                    @if($errors->has('appt'))
                        <div class="alert-mh alert-danger-mh" data-testid="appt-error" style="margin-bottom:.9rem;">
                            {{ $errors->first('appt') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" class="hero-appt-form" data-testid="hero-appointment-form" novalidate>
                        @csrf
                        <input type="hidden" name="source" value="hero_form">
                        <input type="hidden" name="subject" value="Online Appointment Request">

                        <div class="field-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="appt-name">Full Name <span class="req">*</span></label>
                            <div class="input-wrap">
                                <i class="fas fa-user"></i>
                                <input type="text" id="appt-name" name="name" required placeholder="Your name" value="{{ old('name') }}" data-testid="appt-name" autocomplete="name">
                            </div>
                        </div>

                        <div class="field-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label for="appt-phone">Mobile Number <span class="req">*</span></label>
                            <div class="input-wrap">
                                <i class="fas fa-phone"></i>
                                <input type="tel" id="appt-phone" name="phone" required placeholder="10-digit mobile" value="{{ old('phone') }}" data-testid="appt-phone" inputmode="numeric" pattern="[0-9+\-\s]{7,15}" autocomplete="tel">
                            </div>
                        </div>

                        <div class="field-row">
                            <div class="field-group {{ $errors->has('village') ? 'has-error' : '' }}">
                                <label for="appt-village">Village <span class="req">*</span></label>
                                <div class="input-wrap">
                                    <i class="fas fa-house"></i>
                                    <input type="text" id="appt-village" name="village" required placeholder="Village name" value="{{ old('village') }}" data-testid="appt-village">
                                </div>
                            </div>
                            <div class="field-group {{ $errors->has('preferred_doctor') ? 'has-error' : '' }}">
                                <label for="appt-doctor">Doctor <span class="req">*</span></label>
                                <div class="input-wrap select-wrap">
                                    <i class="fas fa-user-doctor"></i>
                                    <select id="appt-doctor" name="preferred_doctor" required data-testid="appt-doctor">
                                        <option value="" disabled {{ old('preferred_doctor') ? '' : 'selected' }}>Select doctor</option>
                                        @foreach($appointmentDoctors as $ad)
                                            <option value="{{ $ad->name }}" {{ old('preferred_doctor') === $ad->name ? 'selected' : '' }}>{{ $ad->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="field-group {{ $errors->has('preferred_date') ? 'has-error' : '' }}">
                            <label for="appt-date">Preferred Date <span class="req">*</span></label>
                            <div class="input-wrap date-wrap">
                                <i class="fas fa-calendar-days"></i>
                                <input type="date" id="appt-date" name="preferred_date" required min="{{ date('Y-m-d') }}" value="{{ old('preferred_date') }}" data-testid="appt-date">
                            </div>
                        </div>

                        <button type="submit" class="btn-mh btn-accent-mh hero-appt-submit" data-testid="appt-submit">
                            <i class="fas fa-paper-plane"></i>
                            <span>Book My Appointment</span>
                        </button>

                        <div class="hero-appt-note">
                            <i class="fas fa-shield-halved"></i>
                            <span>Your details are safe. NABH Standard Protocols · 100% confidential.</span>
                        </div>
                    </form>
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

{{-- TESTIMONIALS (before doctors) --}}
@if($testimonials->count())
<section class="section tinted" data-testid="testimonials-section">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="overline">Patient Stories</span>
            <h2 style="margin-top:1rem;">Real voices from the families we care for.</h2>
        </div>
        <div class="grid-3 testi-grid" data-testid="testimonials-slider">
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
        <div class="testi-hint"><i class="fas fa-arrow-left"></i> Swipe to read more <i class="fas fa-arrow-right"></i></div>
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
                    <div class="featured-doc-bio">{!! $featuredDoctor->description !!}</div>
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
            <div class="grid-4 doctor-grid reveal" style="margin-top:2.5rem;">
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

{{-- FEATURED VIDEOS --}}
@if($featuredVideos->count())
<section class="section tinted" data-testid="featured-videos-section">
    <div class="container-x">
        <div class="section-head reveal">
            <span class="overline">Watch &amp; Follow</span>
            <h2 style="margin-top:1rem;">See Mahaveer Hospital in action.</h2>
            <p>Get a closer look at our facilities, patient stories and health tips on our social channels.</p>
        </div>
        <div class="video-grid reveal">
            @foreach($featuredVideos as $v)
                @php $ytId = $v->platform === 'youtube' ? $v->youtubeId() : null; @endphp
                @if($v->platform === 'youtube' && $ytId)
                    <a href="{{ $v->url }}" target="_blank" rel="noopener" class="video-card yt" data-testid="featured-youtube-{{ $v->id }}">
                        <div class="video-thumb">
                            <img src="https://img.youtube.com/vi/{{ $ytId }}/hqdefault.jpg" alt="{{ $v->title ?: 'YouTube video' }}" loading="lazy">
                            <span class="video-play"><i class="fas fa-play"></i></span>
                            <span class="video-tag"><i class="fab fa-youtube"></i> YouTube</span>
                        </div>
                        <div class="video-meta">
                            <span class="video-title"><i class="fab fa-youtube"></i> {{ $v->title ?: 'Watch on YouTube' }}</span>
                            <i class="fas fa-arrow-up-right-from-square"></i>
                        </div>
                    </a>
                @elseif($v->platform === 'instagram')
                    @php $igThumb = $v->instagramThumb(); @endphp
                    <a href="{{ $v->url }}" target="_blank" rel="noopener" class="video-card ig" data-testid="featured-instagram-{{ $v->id }}">
                        <div class="video-thumb ig-thumb {{ $igThumb ? '' : 'ig-fallback' }}">
                            @if($igThumb)
                                <img src="{{ $igThumb }}" alt="{{ $v->title ?: 'Instagram video' }}" loading="lazy" referrerpolicy="no-referrer"
                                     onerror="this.style.display='none';this.parentNode.classList.add('ig-fallback');">
                            @endif
                            <span class="ig-glyph"><i class="fab fa-instagram"></i></span>
                            <span class="video-play"><i class="fas fa-play"></i></span>
                            <span class="video-tag ig-tag"><i class="fab fa-instagram"></i> Instagram</span>
                        </div>
                        <div class="video-meta">
                            <span class="video-title"><i class="fab fa-instagram"></i> {{ $v->title ?: 'Watch on Instagram' }}</span>
                            <i class="fas fa-arrow-up-right-from-square"></i>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

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
        <div class="cta-band reveal">
            <div class="cta-glow"></div>
            <div class="cta-inner">
                <span class="eyebrow" style="color:var(--c-highlight);">Ready when you are</span>
                <h2>Ready to take the first step towards <span class="italic-swash" style="color:var(--c-highlight);">better health?</span></h2>
                <p>Book an appointment with our specialists today. Same-day slots available for urgent consultations.</p>
                <div class="cta-actions">
                    <a href="{{ route('contact') }}" class="btn-mh btn-accent-mh" data-testid="cta-book"><i class="fas fa-calendar-plus"></i> Book Appointment</a>
                    @if($siteContact?->phone_primary)
                        <a href="tel:{{ $siteContact->phone_primary }}" class="btn-mh cta-ghost" data-testid="cta-call"><i class="fas fa-phone"></i> {{ $siteContact->phone_primary }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
