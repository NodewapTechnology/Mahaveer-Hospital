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
    <meta name="theme-color" content="#3b1f4a">
    <title>{{ $seo?->title ?? (($siteSettings?->site_name ?? 'Mahaveer Hospital') . ' — ' . ($siteSettings?->tagline ?? '')) }}</title>
    @if($seo?->description)<meta name="description" content="{{ $seo->description }}">@endif
    @if($seo?->keywords)<meta name="keywords" content="{{ $seo->keywords }}">@endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght,SOFT,WONK@0,9..144,300..800,0..100,0..1;1,9..144,300..800,0..100,0..1&family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v=8">
    @if($siteSettings?->favicon)<link rel="icon" href="{{ asset($siteSettings->favicon) }}">@endif
    @stack('head')
</head>
<body class="frontend-body">
    @include('frontend.partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

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

    <script src="{{ asset('js/site.js') }}?v=8"></script>
    @stack('scripts')
</body>
</html>
