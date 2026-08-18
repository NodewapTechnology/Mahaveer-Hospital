@php
    $activePath = request()->path();
    // Primary nav — only 4 items visible on desktop, all others go into "More" dropdown
    $primaryLinks = [
        ['url' => url('/'),          'label' => \App\Helpers\I18n::ui('nav.home'),     'path' => '/'],
        ['url' => route('about'),    'label' => \App\Helpers\I18n::ui('nav.about'),    'path' => 'about'],
        ['url' => route('services'), 'label' => \App\Helpers\I18n::ui('nav.services'), 'path' => 'services'],
        ['url' => route('doctors'),  'label' => \App\Helpers\I18n::ui('nav.doctors'),  'path' => 'doctors'],
    ];
    $moreLinks = [
        ['url' => route('gallery'),      'label' => \App\Helpers\I18n::ui('nav.gallery'),      'path' => 'gallery',      'icon' => 'fa-images'],
        ['url' => route('events'),       'label' => \App\Helpers\I18n::ui('nav.events'),       'path' => 'events',       'icon' => 'fa-calendar-days'],
        ['url' => route('offers'),       'label' => \App\Helpers\I18n::ui('nav.offers'),       'path' => 'offers',       'icon' => 'fa-tag'],
        ['url' => route('testimonials'), 'label' => \App\Helpers\I18n::ui('nav.testimonials'), 'path' => 'testimonials', 'icon' => 'fa-comment-medical'],
        ['url' => route('blogs'),        'label' => \App\Helpers\I18n::ui('nav.blog'),         'path' => 'blogs',        'icon' => 'fa-newspaper'],
        ['url' => route('contact'),      'label' => \App\Helpers\I18n::ui('nav.contact'),      'path' => 'contact',      'icon' => 'fa-envelope'],
    ];
    $mobileLinks = array_merge($primaryLinks, $moreLinks);

    $hasLogo = !empty($siteSettings?->logo);
@endphp

<header class="site-header" data-testid="site-header">
    <div class="container-x">
        <div class="header-row">
            <a href="{{ url('/') }}" class="site-brand" aria-label="{{ $siteSettings?->site_name ?? 'Home' }}" data-testid="site-brand">
                @if($hasLogo)
                    <img src="{{ asset($siteSettings->logo) }}" alt="{{ $siteSettings->site_name }}">
                @else
                    {{-- clean logo mark — used when no logo uploaded from admin --}}
                    <span class="brand-mark" aria-hidden="true">
                        <svg width="44" height="44" viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg">
                            <rect width="44" height="44" rx="12" fill="#3b1f4a"/>
                            <path d="M13 30 V14 L22 24 L31 14 V30" stroke="#e5a530" stroke-width="2.6" fill="none" stroke-linejoin="round" stroke-linecap="round"/>
                            <circle cx="22" cy="30.5" r="2.2" fill="#d64a3a"/>
                        </svg>
                    </span>
                @endif
            </a>

            <nav class="nav-desktop" aria-label="Primary">
                @foreach($primaryLinks as $l)
                    <a href="{{ $l['url'] }}" class="{{ $activePath === $l['path'] ? 'active' : '' }}" data-testid="nav-{{ Str::slug($l['label']) }}">{{ $l['label'] }}</a>
                @endforeach
                <div class="nav-more" data-testid="nav-more">
                    <button type="button" aria-haspopup="true" aria-expanded="false">
                        @t('nav.more') <i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="nav-more-panel">
                        @foreach($moreLinks as $l)
                            <a href="{{ $l['url'] }}" class="{{ $activePath === $l['path'] ? 'active' : '' }}" data-testid="nav-more-{{ Str::slug($l['label']) }}">
                                <i class="fas {{ $l['icon'] }}" aria-hidden="true"></i>
                                <span>{{ $l['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </nav>

            <div class="header-actions">
                @if($siteContact?->phone_primary)
                    <a href="tel:{{ $siteContact->phone_primary }}" class="icon-btn icon-call" title="@t('cta.call') · {{ $siteContact->phone_primary }}" data-testid="header-call-btn" aria-label="@t('cta.call')">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                    </a>
                @endif
                <a href="{{ route('contact') }}" class="icon-btn icon-book" data-book-open title="@t('cta.book')" data-testid="header-book-btn" aria-label="@t('cta.book')">
                    <i class="fas fa-calendar-check" aria-hidden="true"></i>
                </a>
                <button type="button" class="mobile-toggle" data-mobile-toggle aria-label="Menu" data-testid="mobile-menu-toggle">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="mobile-menu" data-mobile-menu>
        <div class="container-x">
            @foreach($mobileLinks as $l)
                <a href="{{ $l['url'] }}" class="{{ $activePath === $l['path'] ? 'active' : '' }}" data-testid="mobile-nav-{{ Str::slug($l['label']) }}">
                    <span>{{ $l['label'] }}</span>
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            @endforeach
            <div class="mobile-menu-cta">
                @if($siteContact?->phone_primary)
                    <a href="tel:{{ $siteContact->phone_primary }}" class="btn-mh btn-outline-mh"><i class="fas fa-phone"></i> @t('cta.call')</a>
                @endif
                <a href="{{ route('contact') }}" class="btn-mh btn-primary-mh" data-book-open><i class="fas fa-calendar-check"></i> @t('cta.book')</a>
            </div>
        </div>
    </div>
</header>
