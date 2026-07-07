@php
    $siteSettings = $siteSettings ?? \App\Models\WebsiteSetting::first();
    $siteContact = $siteContact ?? \App\Models\ContactDetail::first();
    $siteSocials = $siteSocials ?? \App\Models\SocialLink::where('is_active', true)->orderBy('sort')->get();
    $seo = $seo ?? null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seo?->title ?? ($siteSettings?->site_name . ' — ' . $siteSettings?->tagline) }}</title>
    @if($seo?->description)<meta name="description" content="{{ $seo->description }}">@endif
    @if($seo?->keywords)<meta name="keywords" content="{{ $seo->keywords }}">@endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600;700&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v=3">
    @if($siteSettings?->favicon)<link rel="icon" href="{{ asset($siteSettings->favicon) }}">@endif
    @stack('head')
</head>
<body class="frontend-body">
    @include('frontend.partials.header')

    <main id="main">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    <a href="tel:{{ $siteContact?->emergency_phone ?? '+916287797276' }}" class="floating-emergency" data-testid="floating-emergency-btn" title="24/7 Emergency">
        <i class="fas fa-phone-flip"></i><span>Emergency</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/site.js') }}?v=3"></script>
    @stack('scripts')
</body>
</html>
