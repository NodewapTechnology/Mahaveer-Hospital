<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') · Mahaveer Hospital CMS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400..600&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=9">
    @php
        $adminWs = \App\Models\WebsiteSetting::first();
        $aToRgb = function ($hex) {
            $hex = ltrim((string) $hex, '#');
            if (strlen($hex) === 3) { $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2]; }
            if (strlen($hex) !== 6) { return null; }
            return [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
        };
        $aAdjust = function ($hex, $pct) use ($aToRgb) {
            $rgb = $aToRgb($hex);
            if (!$rgb) { return $hex; }
            $f = fn($c) => max(0, min(255, (int) round($pct < 0 ? $c * (1 + $pct) : $c + (255 - $c) * $pct)));
            return sprintf('#%02x%02x%02x', $f($rgb[0]), $f($rgb[1]), $f($rgb[2]));
        };
        $aPrimary = ($adminWs?->primary_color && $aToRgb($adminWs->primary_color)) ? $adminWs->primary_color : null;
        $aAccent = ($adminWs?->accent_color && $aToRgb($adminWs->accent_color)) ? $adminWs->accent_color : null;
    @endphp
    @if($aPrimary || $aAccent)
    <style>
        :root {
            @if($aPrimary)
            --a-primary: {{ $aPrimary }};
            --a-primary-2: {{ $aAdjust($aPrimary, -0.22) }};
            --a-primary-dark: {{ $aAdjust($aPrimary, -0.4) }};
            --a-primary-soft: {{ $aAdjust($aPrimary, 0.86) }};
            @endif
            @if($aAccent)
            --a-accent: {{ $aAccent }};
            --a-accent-soft: {{ $aAdjust($aAccent, 0.82) }};
            --a-highlight: {{ $aAccent }};
            @endif
        }
    </style>
    @endif
    {{-- TinyMCE (free self-hosted CDN via jsDelivr for WYSIWYG on .wysiwyg textareas) --}}
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
    @stack('head')
</head>
<body class="admin-body">
    <aside class="admin-sidebar" data-testid="admin-sidebar">
        <div class="brand">
            <div class="mark">M+</div>
            <div>
                <div class="name">Mahaveer CMS</div>
                <div class="tag">Admin Console</div>
            </div>
        </div>
        <nav class="admin-nav">
            @php
                $current = request()->path();
                $groups = [
                    'Overview' => [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'fa-gauge-high', 'match' => ['admin', 'admin/dashboard']],
                        ['route' => 'admin.enquiries.index', 'label' => 'Appointments', 'icon' => 'fa-envelope-open-text', 'match' => ['admin/enquiries']],
                    ],
                    'Website Content' => [
                        ['route' => 'admin.banners.index', 'label' => 'Home Banner', 'icon' => 'fa-images', 'match' => ['admin/banners']],
                        ['route' => 'admin.about.edit', 'label' => 'About Page', 'icon' => 'fa-address-card', 'match' => ['admin/about']],
                        ['route' => 'admin.services.index', 'label' => 'Services', 'icon' => 'fa-hand-holding-medical', 'match' => ['admin/services']],
                        ['route' => 'admin.doctors.index', 'label' => 'Doctors', 'icon' => 'fa-user-doctor', 'match' => ['admin/doctors']],
                        ['route' => 'admin.gallery.index', 'label' => 'Gallery', 'icon' => 'fa-image', 'match' => ['admin/gallery']],
                        ['route' => 'admin.events.index', 'label' => 'Events', 'icon' => 'fa-calendar-days', 'match' => ['admin/events']],
                        ['route' => 'admin.testimonials.index', 'label' => 'Testimonials', 'icon' => 'fa-comment-medical', 'match' => ['admin/testimonials']],
                        ['route' => 'admin.offers.index', 'label' => 'Offers', 'icon' => 'fa-tag', 'match' => ['admin/offers']],
                        ['route' => 'admin.blogs.index', 'label' => 'Blogs', 'icon' => 'fa-newspaper', 'match' => ['admin/blogs']],
                        ['route' => 'admin.faqs.index', 'label' => 'FAQs', 'icon' => 'fa-circle-question', 'match' => ['admin/faqs']],
                    ],
                    'Settings' => [
                        ['route' => 'admin.contact-details.edit', 'label' => 'Contact Info', 'icon' => 'fa-phone', 'match' => ['admin/contact-details']],
                        ['route' => 'admin.social-links.index', 'label' => 'Social Links', 'icon' => 'fa-share-nodes', 'match' => ['admin/social-links']],
                        ['route' => 'admin.videos.index', 'label' => 'Video Links', 'icon' => 'fa-film', 'match' => ['admin/videos']],
                        ['route' => 'admin.seo-settings.index', 'label' => 'SEO Settings', 'icon' => 'fa-magnifying-glass', 'match' => ['admin/seo-settings']],
                        ['route' => 'admin.website-settings.edit', 'label' => 'Website Settings', 'icon' => 'fa-sliders', 'match' => ['admin/website-settings']],
                        ['route' => 'admin.account.edit', 'label' => 'My Account', 'icon' => 'fa-user-gear', 'match' => ['admin/account']],
                    ],
                ];
            @endphp
            @foreach($groups as $groupName => $items)
                <div class="section-label">{{ $groupName }}</div>
                @foreach($items as $m)
                    @php $active = collect($m['match'])->contains(fn($x) => $current === $x || str_starts_with($current, $x . '/')); @endphp
                    <a href="{{ route($m['route']) }}" class="{{ $active ? 'active' : '' }}" data-testid="admin-nav-{{ strtolower(str_replace([' ', '(', ')', '/'], ['-', '', '', ''], $m['label'])) }}">
                        <i class="fas {{ $m['icon'] }}"></i> <span>{{ $m['label'] }}</span>
                    </a>
                @endforeach
            @endforeach
        </nav>
        <div class="admin-sidebar-footer">
            v2 · &copy; {{ date('Y') }} Mahaveer Hospital
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar" data-testid="admin-topbar">
            <button class="topbar-toggle" onclick="document.body.classList.toggle('sidebar-open')" data-testid="admin-sidebar-toggle" aria-label="Toggle sidebar"><i class="fas fa-bars"></i></button>
            <div class="topbar-title">@yield('title', 'Dashboard')</div>
            <div class="topbar-actions">
                <a href="{{ url('/') }}" target="_blank" class="btn-adm btn-outline btn-sm"><i class="fas fa-globe"></i> View Site</a>
                @php $user = auth('admin')->user(); $initial = strtoupper(mb_substr($user?->name ?? 'A', 0, 1)); @endphp
                <span class="topbar-user">
                    <a href="{{ route('admin.account.edit') }}" style="display:flex;align-items:center;gap:.5rem;text-decoration:none;color:inherit;" data-testid="admin-account-link" title="My Account">
                        <span class="avatar">{{ $initial }}</span>
                        <span>{{ $user?->name }}</span>
                    </a>
                </span>
                <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-adm btn-outline btn-sm" data-testid="admin-logout" title="Sign out"><i class="fas fa-right-from-bracket"></i></button>
                </form>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="alert alert-success" data-testid="flash-success"><span>{{ session('success') }}</span></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" data-testid="flash-error"><span>{{ session('error') }}</span></div>
            @endif
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/admin.js') }}?v=5"></script>
    @stack('scripts')
</body>
</html>
