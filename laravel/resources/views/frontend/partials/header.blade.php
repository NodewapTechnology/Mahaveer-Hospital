@php
    $activePath = request()->path();
    // primary nav — first 5 visible on desktop, remaining go in "More" dropdown
    $allLinks = [
        ['url' => url('/'),                 'label' => \App\Helpers\I18n::ui('nav.home'),         'path' => '/'],
        ['url' => route('about'),           'label' => \App\Helpers\I18n::ui('nav.about'),        'path' => 'about'],
        ['url' => route('services'),        'label' => \App\Helpers\I18n::ui('nav.services'),     'path' => 'services'],
        ['url' => route('doctors'),         'label' => \App\Helpers\I18n::ui('nav.doctors'),      'path' => 'doctors'],
        ['url' => route('gallery'),         'label' => \App\Helpers\I18n::ui('nav.gallery'),      'path' => 'gallery'],
        ['url' => route('contact'),         'label' => \App\Helpers\I18n::ui('nav.contact'),      'path' => 'contact'],
    ];
    $moreLinks = [
        ['url' => route('events'),          'label' => \App\Helpers\I18n::ui('nav.events'),       'path' => 'events'],
        ['url' => route('offers'),          'label' => \App\Helpers\I18n::ui('nav.offers'),       'path' => 'offers'],
        ['url' => route('testimonials'),    'label' => \App\Helpers\I18n::ui('nav.testimonials'), 'path' => 'testimonials'],
        ['url' => route('blogs'),           'label' => \App\Helpers\I18n::ui('nav.blog'),         'path' => 'blogs'],
    ];
@endphp

<header class="site-header" data-testid="site-header">
    <div class="container-x">
        <div class="header-row">
            <a href="{{ url('/') }}" class="site-brand" data-testid="site-brand">
                @if($siteSettings?->logo)
                    <img src="{{ asset($siteSettings->logo) }}" alt="{{ $siteSettings->site_name }}">
                @else
                    <span class="brand-fallback">{{ $siteSettings?->site_name ?? 'Mahaveer Hospital' }}</span>
                @endif
            </a>

            <nav class="nav-desktop" aria-label="Primary">
                @foreach($allLinks as $l)
                    <a href="{{ $l['url'] }}" class="{{ $activePath === $l['path'] ? 'active' : '' }}" data-testid="nav-{{ Str::slug($l['label']) }}">{{ $l['label'] }}</a>
                @endforeach
                <div class="nav-more" data-testid="nav-more">
                    <button type="button" aria-haspopup="true" aria-expanded="false">
                        @t('nav.more') <i class="fas fa-chevron-down" style="font-size:.65rem;"></i>
                    </button>
                    <div class="nav-more-panel">
                        @foreach($moreLinks as $l)
                            <a href="{{ $l['url'] }}" data-testid="nav-more-{{ Str::slug($l['label']) }}">{{ $l['label'] }}</a>
                        @endforeach
                    </div>
                </div>
            </nav>

            <div class="header-actions">
                @if($siteSettings?->language_switch_enabled ?? true)
                    <div class="lang-toggle" data-testid="lang-toggle">
                        <a href="{{ route('lang.switch', 'en') }}" class="{{ $currentLang === 'en' ? 'active' : '' }}" data-testid="lang-en">EN</a>
                        <a href="{{ route('lang.switch', 'hi') }}" class="{{ $currentLang === 'hi' ? 'active' : '' }}" data-testid="lang-hi">हि</a>
                    </div>
                @endif
                @if($siteContact?->phone_primary)
                    <a href="tel:{{ $siteContact->phone_primary }}" class="icon-call" title="@t('cta.call') · {{ $siteContact->phone_primary }}" data-testid="header-call-btn">
                        <i class="fas fa-phone"></i>
                        <span class="tt">@t('cta.call'): {{ $siteContact->phone_primary }}</span>
                    </a>
                @endif
                <a href="{{ route('contact') }}" class="icon-book" title="@t('cta.book')" data-testid="header-book-btn">
                    <i class="fas fa-calendar-check"></i>
                    <span class="tt">@t('cta.book')</span>
                </a>
                <button type="button" class="mobile-toggle" data-mobile-toggle aria-label="Menu" data-testid="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="mobile-menu" data-mobile-menu>
        @foreach(array_merge($allLinks, $moreLinks) as $l)
            <a href="{{ $l['url'] }}" data-testid="mobile-nav-{{ Str::slug($l['label']) }}">
                <span>{{ $l['label'] }}</span>
                <i class="fas fa-arrow-right" style="font-size:.75rem;color:var(--c-muted);"></i>
            </a>
        @endforeach
        <div class="mobile-menu-cta">
            @if($siteContact?->phone_primary)
                <a href="tel:{{ $siteContact->phone_primary }}" class="btn-mh btn-outline-mh"><i class="fas fa-phone"></i> @t('cta.call')</a>
            @endif
            <a href="{{ route('contact') }}" class="btn-mh btn-primary-mh"><i class="fas fa-calendar-check"></i> @t('cta.book')</a>
        </div>
    </div>
</header>
