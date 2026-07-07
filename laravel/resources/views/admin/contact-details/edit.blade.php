@extends('admin.layout')
@section('title', 'Contact Details')
@section('content')
<div class="card">
    <div class="card-header"><h2>Contact Details</h2></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ route('admin.contact-details.update') }}">
        @csrf @method('PUT')
        <div class="form-row-3">
            <div class="form-group"><label>Primary Phone</label><input class="form-control" name="phone_primary" value="{{ old('phone_primary', $item->phone_primary) }}"></div>
            <div class="form-group"><label>Secondary Phone</label><input class="form-control" name="phone_secondary" value="{{ old('phone_secondary', $item->phone_secondary) }}"></div>
            <div class="form-group"><label>Emergency Phone</label><input class="form-control" name="emergency_phone" value="{{ old('emergency_phone', $item->emergency_phone) }}"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Primary Email</label><input type="email" class="form-control" name="email_primary" value="{{ old('email_primary', $item->email_primary) }}"></div>
            <div class="form-group"><label>Support Email</label><input type="email" class="form-control" name="email_support" value="{{ old('email_support', $item->email_support) }}"></div>
        </div>
        <div class="form-group"><label>Address</label><textarea class="form-control" name="address" rows="2">{{ old('address', $item->address) }}</textarea></div>
        <div class="form-row-3">
            <div class="form-group"><label>City</label><input class="form-control" name="city" value="{{ old('city', $item->city) }}"></div>
            <div class="form-group"><label>State</label><input class="form-control" name="state" value="{{ old('state', $item->state) }}"></div>
            <div class="form-group"><label>PIN</label><input class="form-control" name="pincode" value="{{ old('pincode', $item->pincode) }}"></div>
        </div>
        <div class="form-group"><label>Opening Hours</label><input class="form-control" name="opening_hours" value="{{ old('opening_hours', $item->opening_hours) }}"></div>
        <div class="form-group"><label>Google Map Embed URL</label><textarea class="form-control" name="map_embed" rows="2">{{ old('map_embed', $item->map_embed) }}</textarea>
            <div class="form-help">Only the URL from Google Maps embed iframe (src attribute value).</div>
        </div>
        <button type="submit" class="btn-adm btn-primary"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
