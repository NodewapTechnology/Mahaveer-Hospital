<footer class="site-footer" data-testid="site-footer">
    <div class="container-x">
        <div class="footer-grid">
            <div>
                @if($siteSettings?->logo)
                    <img src="{{ asset($siteSettings->logo) }}" alt="logo" style="max-height:60px;width:auto;background:#fff;padding:8px 14px;border-radius:12px;">
                @endif
                <div class="footer-brand">{{ $siteSettings?->site_name ?? 'Mahaveer Hospital' }}</div>
                <p style="max-width:340px;margin-top:.5rem;">{{ $siteSettings?->footer_text }}</p>
                <div class="footer-socials">
                    @foreach($siteSocials as $s)
                        <a href="{{ $s->url }}" target="_blank" rel="noopener" title="{{ $s->platform }}" data-testid="social-{{ strtolower($s->platform) }}">
                            <i class="{{ $s->icon ?: 'fas fa-link' }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h5>{{ \App\Helpers\I18n::ui('nav.more') }}</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('about') }}">@t('nav.about')</a></li>
                    <li><a href="{{ route('doctors') }}">@t('nav.doctors')</a></li>
                    <li><a href="{{ route('services') }}">@t('nav.services')</a></li>
                    <li><a href="{{ route('gallery') }}">@t('nav.gallery')</a></li>
                    <li><a href="{{ route('events') }}">@t('nav.events')</a></li>
                    <li><a href="{{ route('offers') }}">@t('nav.offers')</a></li>
                </ul>
            </div>

            <div>
                <h5>@t('label.testimonials')</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('testimonials') }}">@t('nav.testimonials')</a></li>
                    <li><a href="{{ route('blogs') }}">@t('nav.blog')</a></li>
                    <li><a href="{{ route('contact') }}">@t('nav.contact')</a></li>
                    <li><a href="{{ route('contact') }}">@t('cta.book')</a></li>
                    @if($siteContact?->emergency_phone)
                        <li><a href="tel:{{ $siteContact->emergency_phone }}">@t('label.emergency')</a></li>
                    @endif
                </ul>
            </div>

            <div>
                <h5>@t('label.contact_us')</h5>
                <ul class="footer-links" style="line-height:1.75">
                    @if($siteContact?->address)
                        <li><i class="fas fa-location-dot" style="color:var(--c-highlight);margin-right:.4rem;"></i>{{ $siteContact->address }}, {{ $siteContact->city }}, {{ $siteContact->state }} {{ $siteContact->pincode }}</li>
                    @endif
                    @if($siteContact?->phone_primary)
                        <li><i class="fas fa-phone" style="color:var(--c-highlight);margin-right:.4rem;"></i><a href="tel:{{ $siteContact->phone_primary }}">{{ $siteContact->phone_primary }}</a></li>
                    @endif
                    @if($siteContact?->email_primary)
                        <li><i class="fas fa-envelope" style="color:var(--c-highlight);margin-right:.4rem;"></i><a href="mailto:{{ $siteContact->email_primary }}">{{ $siteContact->email_primary }}</a></li>
                    @endif
                    @if($siteContact?->opening_hours)
                        <li><i class="fas fa-clock" style="color:var(--c-highlight);margin-right:.4rem;"></i>{{ $siteContact->opening_hours }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>{{ $siteSettings?->copyright_text ?? ('© ' . date('Y') . ' ' . ($siteSettings?->site_name ?? 'Mahaveer Hospital') . '. All rights reserved.') }}</div>
            <div style="margin-top:.4rem;"><a href="{{ route('admin.login') }}" style="color:rgba(255,255,255,.4);font-size:.78rem;" data-testid="admin-login-link">Admin</a></div>
        </div>
    </div>
</footer>
