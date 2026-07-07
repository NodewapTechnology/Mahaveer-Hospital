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
            <div class="form-group"><label>Primary Color</label><input type="color" class="form-control" name="primary_color" value="{{ old('primary_color', $item->primary_color) }}"></div>
            <div class="form-group"><label>Accent Color</label><input type="color" class="form-control" name="accent_color" value="{{ old('accent_color', $item->accent_color) }}"></div>
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
        <button type="submit" class="btn-adm btn-primary"><i class="fas fa-save"></i> Save Settings</button>
    </form>
</div>
@endsection
