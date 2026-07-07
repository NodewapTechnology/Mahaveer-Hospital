@extends('admin.layout')
@section('title', $item->exists ? 'Edit Social Link' : 'New Social Link')
@section('content')
<div class="card">
    <div class="card-header"><h2>{{ $item->exists ? 'Edit Social Link' : 'Add Social Link' }}</h2><a href="{{ route('admin.social-links.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ $item->exists ? route('admin.social-links.update', $item) : route('admin.social-links.store') }}">
        @csrf @if($item->exists)@method('PUT')@endif
        <div class="form-row">
            <div class="form-group"><label>Platform <span class="req">*</span></label><input class="form-control" name="platform" value="{{ old('platform', $item->platform) }}" required></div>
            <div class="form-group"><label>Font Awesome Icon Class</label><input class="form-control" name="icon" value="{{ old('icon', $item->icon) }}" placeholder="e.g. fab fa-facebook-f"></div>
        </div>
        <div class="form-group"><label>URL <span class="req">*</span></label><input class="form-control" name="url" value="{{ old('url', $item->url) }}" required></div>
        <div class="form-row">
            <div class="form-group"><label>Sort</label><input type="number" class="form-control" name="sort" value="{{ old('sort', $item->sort ?? 0) }}"></div>
            <div class="form-group" style="align-self:end;"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Show on website</label></div>
        </div>
        <button type="submit" class="btn-adm btn-primary"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
