<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') · Mahaveer Hospital CMS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v=5">
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
                $menu = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'fa-gauge-high', 'match' => ['admin', 'admin/dashboard']],
                    ['route' => 'admin.enquiries.index', 'label' => 'Enquiries', 'icon' => 'fa-envelope-open-text', 'match' => ['admin/enquiries']],
                    ['route' => 'admin.banners.index', 'label' => 'Banners', 'icon' => 'fa-images', 'match' => ['admin/banners']],
                    ['route' => 'admin.about.edit', 'label' => 'About Page', 'icon' => 'fa-address-card', 'match' => ['admin/about']],
                    ['route' => 'admin.services.index', 'label' => 'Services', 'icon' => 'fa-hand-holding-medical', 'match' => ['admin/services']],
                    ['route' => 'admin.doctors.index', 'label' => 'Doctors', 'icon' => 'fa-user-doctor', 'match' => ['admin/doctors']],
                    ['route' => 'admin.gallery.index', 'label' => 'Gallery', 'icon' => 'fa-image', 'match' => ['admin/gallery']],
                    ['route' => 'admin.events.index', 'label' => 'Events', 'icon' => 'fa-calendar-days', 'match' => ['admin/events']],
                    ['route' => 'admin.testimonials.index', 'label' => 'Testimonials', 'icon' => 'fa-comment-medical', 'match' => ['admin/testimonials']],
                    ['route' => 'admin.offers.index', 'label' => 'Offers', 'icon' => 'fa-tag', 'match' => ['admin/offers']],
                    ['route' => 'admin.blogs.index', 'label' => 'Blogs', 'icon' => 'fa-newspaper', 'match' => ['admin/blogs']],
                    ['route' => 'admin.faqs.index', 'label' => 'FAQs', 'icon' => 'fa-circle-question', 'match' => ['admin/faqs']],
                    ['route' => 'admin.contact-details.edit', 'label' => 'Contact Details', 'icon' => 'fa-phone', 'match' => ['admin/contact-details']],
                    ['route' => 'admin.social-links.index', 'label' => 'Social Links', 'icon' => 'fa-share-nodes', 'match' => ['admin/social-links']],
                    ['route' => 'admin.seo-settings.index', 'label' => 'SEO Settings', 'icon' => 'fa-magnifying-glass', 'match' => ['admin/seo-settings']],
                    ['route' => 'admin.website-settings.edit', 'label' => 'Website Settings', 'icon' => 'fa-sliders', 'match' => ['admin/website-settings']],
                    ['route' => 'admin.translations.index', 'label' => 'Translations (EN/HI)', 'icon' => 'fa-language', 'match' => ['admin/translations']],
                ];
            @endphp
            @foreach($menu as $m)
                @php $active = collect($m['match'])->contains(fn($x) => $current === $x || str_starts_with($current, $x . '/')); @endphp
                <a href="{{ route($m['route']) }}" class="{{ $active ? 'active' : '' }}" data-testid="admin-nav-{{ strtolower(str_replace(' ', '-', $m['label'])) }}">
                    <i class="fas {{ $m['icon'] }}"></i> <span>{{ $m['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar" data-testid="admin-topbar">
            <button class="topbar-toggle" onclick="document.body.classList.toggle('sidebar-open')" data-testid="admin-sidebar-toggle"><i class="fas fa-bars"></i></button>
            <div class="topbar-title">@yield('title', 'Dashboard')</div>
            <div class="topbar-actions">
                <a href="{{ url('/') }}" target="_blank" class="btn-adm btn-outline"><i class="fas fa-globe"></i> View Site</a>
                <span style="color:#94a3b8;">|</span>
                <span style="color:#334155;font-weight:500;"><i class="fas fa-user-circle"></i> {{ auth('admin')->user()->name }}</span>
                <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-adm btn-outline" data-testid="admin-logout"><i class="fas fa-right-from-bracket"></i> Logout</button>
                </form>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="alert alert-success" data-testid="flash-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" data-testid="flash-error">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/admin.js') }}?v=3"></script>
</body>
</html>
