@php
    $activePath = request()->path();
    $links = [
        ['url' => url('/'), 'label' => 'Home', 'path' => '/'],
        ['url' => route('about'), 'label' => 'About', 'path' => 'about'],
        ['url' => route('services'), 'label' => 'Services', 'path' => 'services'],
        ['url' => route('doctors'), 'label' => 'Doctors', 'path' => 'doctors'],
        ['url' => route('gallery'), 'label' => 'Gallery', 'path' => 'gallery'],
        ['url' => route('events'), 'label' => 'Events', 'path' => 'events'],
        ['url' => route('offers'), 'label' => 'Offers', 'path' => 'offers'],
        ['url' => route('testimonials'), 'label' => 'Testimonials', 'path' => 'testimonials'],
        ['url' => route('blogs'), 'label' => 'Blog', 'path' => 'blogs'],
        ['url' => route('contact'), 'label' => 'Contact', 'path' => 'contact'],
    ];
@endphp
<header class="site-header" data-testid="site-header">
    <div class="container-x">
        <a href="{{ url('/') }}" class="site-brand" data-testid="site-brand">
            @if($siteSettings?->logo)
                <img src="{{ asset($siteSettings->logo) }}" alt="{{ $siteSettings->site_name }}" style="height:44px;width:auto;">
            @else
                <div class="brand-mark">M+</div>
            @endif
            <div>
                <div class="brand-name">{{ $siteSettings?->site_name ?? 'Mahaveer Hospital' }}</div>
                <div class="brand-tag">Trusted Multi-Speciality Care</div>
            </div>
        </a>

        <nav class="nav-links" aria-label="Primary">
            @foreach($links as $l)
                <a href="{{ $l['url'] }}" class="{{ $activePath === $l['path'] ? 'active' : '' }}" data-testid="nav-{{ strtolower($l['label']) }}">{{ $l['label'] }}</a>
            @endforeach
        </nav>

        <div class="header-cta">
            <a href="tel:{{ $siteContact?->phone_primary ?? '+916287797276' }}" class="btn-mh btn-outline-mh" data-testid="header-call-btn">
                <i class="fas fa-phone"></i>
                <span>{{ $siteContact?->phone_primary ?? 'Call Us' }}</span>
            </a>
            <a href="{{ route('contact') }}" class="btn-mh btn-primary-mh" data-testid="header-book-btn">
                <i class="fas fa-calendar-plus"></i>
                <span>{{ $siteSettings?->appointment_cta_label ?? 'Book Appointment' }}</span>
            </a>
        </div>

        <button class="mobile-toggle" data-mobile-toggle aria-label="Menu" data-testid="mobile-menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="mobile-menu" data-mobile-menu>
        @foreach($links as $l)
            <a href="{{ $l['url'] }}" data-testid="mobile-nav-{{ strtolower($l['label']) }}">{{ $l['label'] }}</a>
        @endforeach
        <div class="mt-6" style="display:flex;gap:.5rem;flex-wrap:wrap;">
            <a href="tel:{{ $siteContact?->phone_primary ?? '+916287797276' }}" class="btn-mh btn-outline-mh" style="flex:1;justify-content:center;">
                <i class="fas fa-phone"></i> Call
            </a>
            <a href="{{ route('contact') }}" class="btn-mh btn-primary-mh" style="flex:1;justify-content:center;">
                <i class="fas fa-calendar-plus"></i> Book
            </a>
        </div>
    </div>
</header>
