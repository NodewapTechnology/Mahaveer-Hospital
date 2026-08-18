@extends('admin.layout')
@section('title', 'Website Settings')
@section('content')
<div class="card">
    <div class="card-header"><h2>Website Settings</h2></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.website-settings.update') }}">
        @csrf @method('PUT')
        <div class="form-row">
            <div class="form-group"><label>Site Name <span class="req">*</span></label><input class="form-control" name="site_name" value="{{ old('site_name', $item->site_name) }}" required></div>
            <div class="form-group"><label>Tagline</label><input class="form-control" name="tagline" value="{{ old('tagline', $item->tagline) }}"></div>
        </div>
        <div class="form-group"><label>Footer Text</label><textarea class="form-control" name="footer_text" rows="2">{{ old('footer_text', $item->footer_text) }}</textarea></div>
        <div class="form-group"><label>Copyright Text</label><input class="form-control" name="copyright_text" value="{{ old('copyright_text', $item->copyright_text) }}"></div>
        <div class="form-group"><label>Appointment CTA Label</label><input class="form-control" name="appointment_cta_label" value="{{ old('appointment_cta_label', $item->appointment_cta_label) }}"></div>
        <div class="form-row">
            <div class="form-group">
                <label>Primary Color</label>
                <div class="color-field">
                    <input type="color" class="color-swatch" name="primary_color" value="{{ old('primary_color', $item->primary_color ?: '#3b1f4a') }}" data-testid="ws-primary-color" oninput="this.nextElementSibling.value=this.value">
                    <input type="text" class="form-control color-hex" value="{{ old('primary_color', $item->primary_color ?: '#3b1f4a') }}" oninput="this.previousElementSibling.value=this.value" data-testid="ws-primary-color-hex">
                </div>
                <div class="form-help">Applied as the main brand colour across the website (headers, buttons, footer).</div>
            </div>
            <div class="form-group">
                <label>Accent Color</label>
                <div class="color-field">
                    <input type="color" class="color-swatch" name="accent_color" value="{{ old('accent_color', $item->accent_color ?: '#d64a3a') }}" data-testid="ws-accent-color" oninput="this.nextElementSibling.value=this.value">
                    <input type="text" class="form-control color-hex" value="{{ old('accent_color', $item->accent_color ?: '#d64a3a') }}" oninput="this.previousElementSibling.value=this.value" data-testid="ws-accent-color-hex">
                </div>
                <div class="form-help">Used for highlights, links and call-to-action accents.</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Logo</label>
                <input type="file" name="logo" accept="image/*" class="form-control" data-preview="ws-logo">
                @if($item->logo)<img id="ws-logo" src="{{ asset($item->logo) }}" class="image-preview">@else<img id="ws-logo" class="image-preview" style="display:none;">@endif
            </div>
            <div class="form-group">
                <label>Favicon</label>
                <input type="file" name="favicon" accept="image/*" class="form-control" data-preview="ws-fav">
                @if($item->favicon)<img id="ws-fav" src="{{ asset($item->favicon) }}" class="image-preview">@else<img id="ws-fav" class="image-preview" style="display:none;">@endif
            </div>
        </div>

        <div style="margin:2rem 0 1rem;padding-top:1.5rem;border-top:1px solid var(--a-line);">
            <h3 style="font-family:'Fraunces',serif;font-weight:500;color:var(--a-primary);margin:0 0 .3rem;font-size:1.15rem;">Notifications &amp; Security</h3>
            <p class="text-muted" style="margin:0 0 1rem;font-size:.85rem;">Configure Google reCAPTCHA v3 to protect the contact form from spam, and set an email address to receive new enquiry notifications.</p>
        </div>
        <div class="form-group">
            <label>Enquiry Notification Email</label>
            <input class="form-control" type="email" name="notify_email" value="{{ old('notify_email', $item->notify_email ?? '') }}" placeholder="admin@example.com">
            <div class="form-help">New appointment enquiries will be emailed here. Leave blank to use the contact page email address.</div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>reCAPTCHA Site Key</label>
                <input class="form-control" name="recaptcha_site_key" value="{{ old('recaptcha_site_key', $item->recaptcha_site_key ?? '') }}" placeholder="6Lc...">
                <div class="form-help">Get one at <a href="https://www.google.com/recaptcha/admin" target="_blank">google.com/recaptcha/admin</a> (v3 · your site)</div>
            </div>
            <div class="form-group">
                <label>reCAPTCHA Secret Key</label>
                <input class="form-control" name="recaptcha_secret_key" value="{{ old('recaptcha_secret_key', $item->recaptcha_secret_key ?? '') }}" placeholder="6Lc...">
                <div class="form-help">Keep this secret. Leave both blank to disable captcha.</div>
            </div>
        </div>

        <button type="submit" class="btn-adm btn-primary"><i class="fas fa-save"></i> Save Settings</button>
    </form>
</div>
@endsection
