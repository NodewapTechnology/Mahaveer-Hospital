@php
    $siteSettings = $siteSettings ?? \App\Models\WebsiteSetting::first();
    $siteContact = $siteContact ?? \App\Models\ContactDetail::first();
    $siteSocials = $siteSocials ?? \App\Models\SocialLink::where('is_active', true)->orderBy('sort')->get();
    $currentLang = $currentLang ?? session('lang', 'en');
    $seo = $seo ?? null;
    $waRaw = $siteContact?->whatsapp_number ?: $siteContact?->phone_primary;
    $waNumber = $waRaw ? preg_replace('/[^0-9]/', '', $waRaw) : null;
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLang }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="theme-color" content="{{ $siteSettings?->primary_color ?: '#3b1f4a' }}">
    <title>{{ $seo?->title ?? (($siteSettings?->site_name ?? 'Mahaveer Hospital') . ' — ' . ($siteSettings?->tagline ?? '')) }}</title>
    @if($seo?->description)<meta name="description" content="{{ $seo->description }}">@endif
    @if($seo?->keywords)<meta name="keywords" content="{{ $seo->keywords }}">@endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght,SOFT,WONK@0,9..144,300..800,0..100,0..1;1,9..144,300..800,0..100,0..1&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v=17">
    @php
        $mhToRgb = function ($hex) {
            $hex = ltrim((string) $hex, '#');
            if (strlen($hex) === 3) { $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2]; }
            if (strlen($hex) !== 6) { return null; }
            return [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
        };
        $mhAdjust = function ($hex, $pct) use ($mhToRgb) {
            $rgb = $mhToRgb($hex);
            if (!$rgb) { return $hex; }
            $f = fn($c) => max(0, min(255, (int) round($pct < 0 ? $c * (1 + $pct) : $c + (255 - $c) * $pct)));
            return sprintf('#%02x%02x%02x', $f($rgb[0]), $f($rgb[1]), $f($rgb[2]));
        };
        $mhPrimary = ($siteSettings?->primary_color && $mhToRgb($siteSettings->primary_color)) ? $siteSettings->primary_color : null;
        $mhAccent = ($siteSettings?->accent_color && $mhToRgb($siteSettings->accent_color)) ? $siteSettings->accent_color : null;
    @endphp
    @if($mhPrimary || $mhAccent)
    <style>
        :root {
            @if($mhPrimary)
            --c-primary: {{ $mhPrimary }};
            --c-primary-2: {{ $mhAdjust($mhPrimary, -0.28) }};
            --c-primary-soft: {{ $mhAdjust($mhPrimary, 0.85) }};
            @endif
            @if($mhAccent)
            --c-accent: {{ $mhAccent }};
            --c-accent-2: {{ $mhAdjust($mhAccent, -0.2) }};
            --c-accent-soft: {{ $mhAdjust($mhAccent, 0.82) }};
            --c-highlight: {{ $mhAccent }};
            --c-highlight-soft: {{ $mhAdjust($mhAccent, 0.82) }};
            @endif
        }
    </style>
    @endif
    @if($siteSettings?->favicon)<link rel="icon" href="{{ asset($siteSettings->favicon) }}?v={{ $siteSettings->updated_at?->timestamp }}">@endif
    @stack('head')
</head>
<body class="frontend-body">
    @include('frontend.partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    @include('frontend.partials.booking-modal')

    @if(session('appointment_success'))
        <div class="book-toast" data-book-toast data-testid="booking-toast">
            <i class="fas fa-circle-check"></i>
            <span>{{ session('appointment_success') }}</span>
        </div>
    @endif

    {{-- Mobile app-style bottom tab bar --}}
    @php $ap = request()->path(); @endphp
    <nav class="app-tabbar" data-testid="app-tabbar" aria-label="Mobile navigation">
        <a href="{{ url('/') }}" class="{{ $ap === '/' ? 'active' : '' }}" data-testid="tab-home"><i class="fas fa-house"></i><span class="lbl">Home</span></a>
        <a href="{{ route('services') }}" class="{{ str_starts_with($ap,'services') ? 'active' : '' }}" data-testid="tab-care"><i class="fas fa-hand-holding-medical"></i><span class="lbl">Care</span></a>
        <a href="{{ route('contact') }}" class="tab-book" data-book-open data-testid="tab-book"><span class="tab-book-btn"><i class="fas fa-calendar-check"></i></span><span class="lbl">Book</span></a>
        <a href="{{ route('doctors') }}" class="{{ str_starts_with($ap,'doctors') ? 'active' : '' }}" data-testid="tab-doctors"><i class="fas fa-user-doctor"></i><span class="lbl">Doctors</span></a>
        @if($siteContact?->phone_primary)
            <a href="tel:{{ $siteContact->phone_primary }}" data-testid="tab-call"><i class="fas fa-phone"></i><span class="lbl">Call</span></a>
        @else
            <a href="{{ route('contact') }}" data-testid="tab-contact"><i class="fas fa-envelope"></i><span class="lbl">Contact</span></a>
        @endif
    </nav>

    @if($waNumber)
        <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" class="floating-wa" title="@t('label.chat_whatsapp')" data-testid="floating-whatsapp">
            <i class="fab fa-whatsapp"></i>
        </a>
    @endif
    @if($siteContact?->emergency_phone)
        <a href="tel:{{ $siteContact->emergency_phone }}" class="floating-em" data-testid="floating-emergency">
            <i class="fas fa-phone-volume"></i>
            <span class="lbl">@t('label.emergency')</span>
        </a>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="{{ asset('js/site.js') }}?v=12"></script>
    @stack('scripts')
</body>
</html>
