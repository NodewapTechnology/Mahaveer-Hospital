@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / Contact</div>
        <span class="overline">Reach Us</span>
        <h1 style="margin-top:1rem;">We're here for you — always.</h1>
        <p>Book an appointment or drop us a note. Our care team responds within a few hours.</p>
    </div>
</section>

<section class="section">
    <div class="container-x">
        <div class="contact-wrap" data-testid="contact-wrap">
            <div class="contact-info">
                <h3>Get in touch</h3>
                <p style="color:rgba(255,255,255,.85);margin-top:.5rem;">Prefer talking? Call our 24×7 helpline — a real human always answers.</p>

                @if($siteContact?->phone_primary)
                    <div class="info-block">
                        <div class="ico"><i class="fas fa-phone"></i></div>
                        <div><div class="lbl">Phone</div><div class="val">{{ $siteContact->phone_primary }}</div>@if($siteContact->phone_secondary)<div class="val" style="opacity:.85;">{{ $siteContact->phone_secondary }}</div>@endif</div>
                    </div>
                @endif
                @if($siteContact?->email_primary)
                    <div class="info-block">
                        <div class="ico"><i class="fas fa-envelope"></i></div>
                        <div><div class="lbl">Email</div><div class="val">{{ $siteContact->email_primary }}</div></div>
                    </div>
                @endif
                @if($siteContact?->address)
                    <div class="info-block">
                        <div class="ico"><i class="fas fa-location-dot"></i></div>
                        <div><div class="lbl">Visit</div><div class="val">{{ $siteContact->address }}, {{ $siteContact->city }}, {{ $siteContact->state }} {{ $siteContact->pincode }}</div></div>
                    </div>
                @endif
                @if($siteContact?->opening_hours)
                    <div class="info-block">
                        <div class="ico"><i class="fas fa-clock"></i></div>
                        <div><div class="lbl">Hours</div><div class="val">{{ $siteContact->opening_hours }}</div></div>
                    </div>
                @endif
            </div>

            <div class="contact-form-panel">
                <h3 style="font-family:var(--font-display);">Book an Appointment</h3>
                <p style="color:var(--c-muted);margin-top:.35rem;">Fill this quick form — we'll call you back to confirm.</p>

                @if(session('success'))
                    <div class="alert-mh alert-success-mh" style="margin-top:1rem;" data-testid="contact-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert-mh alert-danger-mh" style="margin-top:1rem;" data-testid="contact-errors">
                        <ul style="margin:0;padding-left:1.2rem;">
                            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}" style="margin-top:1.25rem;display:grid;gap:1rem;" data-testid="contact-form">
                    @csrf
                    <input type="hidden" name="source" value="appointment">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div><label for="name">Name*</label><input type="text" id="name" name="name" required class="form-control-mh" data-testid="contact-name" value="{{ old('name') }}"></div>
                        <div><label for="phone">Phone*</label><input type="tel" id="phone" name="phone" required class="form-control-mh" data-testid="contact-phone" value="{{ old('phone') }}"></div>
                    </div>
                    <div><label for="email">Email</label><input type="email" id="email" name="email" class="form-control-mh" data-testid="contact-email" value="{{ old('email') }}"></div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div>
                            <label for="preferred_doctor">Preferred Doctor</label>
                            <select id="preferred_doctor" name="preferred_doctor" class="form-control-mh" data-testid="contact-doctor">
                                <option value="">Any Available</option>
                                @foreach($doctors as $d)<option value="{{ $d->name }}" @selected(old('preferred_doctor') === $d->name)>{{ $d->name }}</option>@endforeach
                            </select>
                        </div>
                        <div><label for="preferred_date">Preferred Date</label><input type="date" id="preferred_date" name="preferred_date" class="form-control-mh" data-testid="contact-date" value="{{ old('preferred_date') }}"></div>
                    </div>
                    <div><label for="subject">Subject</label><input type="text" id="subject" name="subject" class="form-control-mh" data-testid="contact-subject" value="{{ old('subject', 'Appointment Request') }}"></div>
                    <div><label for="message">Message</label><textarea id="message" name="message" class="form-control-mh" data-testid="contact-message">{{ old('message') }}</textarea></div>
                    @php $recaptchaKey = optional(\App\Models\WebsiteSetting::first())->recaptcha_site_key ?: config('mahaveer.site_key'); @endphp
                    @if($recaptchaKey)
                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                        <div style="font-size:.72rem;color:var(--c-muted);">Protected by reCAPTCHA — <a href="https://policies.google.com/privacy" target="_blank" rel="noopener" style="color:var(--c-primary);">Privacy</a> &amp; <a href="https://policies.google.com/terms" target="_blank" rel="noopener" style="color:var(--c-primary);">Terms</a></div>
                    @endif
                    <button type="submit" class="btn-mh btn-primary-mh" style="justify-self:start;" data-testid="contact-submit"><i class="fas fa-paper-plane"></i> Send Enquiry</button>
                </form>
            </div>
        </div>

        @if($siteContact?->map_embed)
            <div style="margin-top:3rem;border-radius:var(--r-lg);overflow:hidden;border:1px solid var(--c-line);height:400px;">
                <iframe src="{{ $siteContact->map_embed }}" style="border:0;width:100%;height:100%;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        @endif
    </div>
</section>

@php $siteKey = optional(\App\Models\WebsiteSetting::first())->recaptcha_site_key ?: config('mahaveer.site_key'); @endphp
@if($siteKey)
    <script src="https://www.google.com/recaptcha/api.js?render={{ $siteKey }}"></script>
    <script>
        (function() {
            const form = document.querySelector('form[data-testid="contact-form"]');
            if (!form) return;
            form.addEventListener('submit', (e) => {
                if (form.dataset.captchaReady === '1') return;
                e.preventDefault();
                grecaptcha.ready(() => {
                    grecaptcha.execute('{{ $siteKey }}', {action: 'enquiry'}).then((token) => {
                        document.getElementById('g-recaptcha-response').value = token;
                        form.dataset.captchaReady = '1';
                        form.submit();
                    });
                });
            });
        })();
    </script>
@endif
@endsection
