<footer class="site-footer" data-testid="site-footer">
    <div class="container-x">
        <div class="footer-grid">
            <div>
                @if($siteSettings?->logo)
                    <img src="{{ asset($siteSettings->logo) }}" alt="logo" style="height:56px;width:auto;background:#fff;padding:8px;border-radius:12px;">
                @else
                    <div style="width:52px;height:52px;background:var(--c-accent);color:#fff;border-radius:14px;display:grid;place-items:center;font-family:var(--font-display);font-weight:700;font-size:1.2rem;">M+</div>
                @endif
                <div class="footer-brand-name">{{ $siteSettings?->site_name ?? 'Mahaveer Hospital' }}</div>
                <p style="max-width:340px;margin-top:.5rem;">{{ $siteSettings?->footer_text ?? 'Compassionate care rooted in North Bihar.' }}</p>
                <div class="footer-socials">
                    @foreach($siteSocials as $s)
                        <a href="{{ $s->url }}" target="_blank" rel="noopener" title="{{ $s->platform }}" data-testid="social-{{ strtolower($s->platform) }}">
                            <i class="{{ $s->icon ?: 'fas fa-link' }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h5>Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('doctors') }}">Our Doctors</a></li>
                    <li><a href="{{ route('services') }}">Services</a></li>
                    <li><a href="{{ route('gallery') }}">Gallery</a></li>
                    <li><a href="{{ route('events') }}">Events</a></li>
                    <li><a href="{{ route('offers') }}">Offers</a></li>
                </ul>
            </div>

            <div>
                <h5>Care</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('testimonials') }}">Testimonials</a></li>
                    <li><a href="{{ route('blogs') }}">Health Blog</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li><a href="{{ route('contact') }}">Book Appointment</a></li>
                    <li><a href="tel:{{ $siteContact?->emergency_phone }}">24×7 Emergency</a></li>
                </ul>
            </div>

            <div>
                <h5>Reach Us</h5>
                <ul class="footer-links" style="line-height:1.7">
                    @if($siteContact?->address)
                        <li><i class="fas fa-location-dot" style="color:var(--c-accent);margin-right:.4rem;"></i>{{ $siteContact->address }}, {{ $siteContact->city }}, {{ $siteContact->state }} {{ $siteContact->pincode }}</li>
                    @endif
                    @if($siteContact?->phone_primary)
                        <li><i class="fas fa-phone" style="color:var(--c-accent);margin-right:.4rem;"></i><a href="tel:{{ $siteContact->phone_primary }}">{{ $siteContact->phone_primary }}</a></li>
                    @endif
                    @if($siteContact?->email_primary)
                        <li><i class="fas fa-envelope" style="color:var(--c-accent);margin-right:.4rem;"></i><a href="mailto:{{ $siteContact->email_primary }}">{{ $siteContact->email_primary }}</a></li>
                    @endif
                    @if($siteContact?->opening_hours)
                        <li><i class="fas fa-clock" style="color:var(--c-accent);margin-right:.4rem;"></i>{{ $siteContact->opening_hours }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>{{ $siteSettings?->copyright_text ?? ('© ' . date('Y') . ' Mahaveer Hospital. All rights reserved.') }}</div>
            <div style="margin-top:.4rem;"><a href="{{ route('admin.login') }}" style="color:rgba(255,255,255,.4);font-size:.78rem;" data-testid="admin-login-link">Admin Login</a></div>
        </div>
    </div>
</footer>
