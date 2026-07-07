@extends('admin.layout')
@section('title', $item->exists ? 'Edit Banner' : 'New Banner')

@section('content')
<div class="card">
    <div class="card-header"><h2>{{ $item->exists ? 'Edit Banner' : 'Add New Banner' }}</h2><a href="{{ route('admin.banners.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.banners.update', $item) : route('admin.banners.store') }}" data-testid="banner-form">
        @csrf @if($item->exists) @method('PUT') @endif
        <div class="form-group"><label>Title <span class="req">*</span></label><input class="form-control" name="title" value="{{ old('title', $item->title) }}" required data-testid="banner-title"></div>
        <div class="form-group"><label>Subtitle</label><textarea class="form-control" name="subtitle" data-testid="banner-subtitle">{{ old('subtitle', $item->subtitle) }}</textarea></div>
        <div class="form-row">
            <div class="form-group"><label>Badge</label><input class="form-control" name="badge" value="{{ old('badge', $item->badge) }}"></div>
            <div class="form-group"><label>Sort Order</label><input type="number" class="form-control" name="sort" value="{{ old('sort', $item->sort ?? 0) }}"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>CTA Text</label><input class="form-control" name="cta_text" value="{{ old('cta_text', $item->cta_text) }}"></div>
            <div class="form-group"><label>CTA Link</label><input class="form-control" name="cta_link" value="{{ old('cta_link', $item->cta_link) }}"></div>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" accept="image/*" class="form-control" data-preview="banner-img-preview">
            @if($item->image)<img id="banner-img-preview" src="{{ asset($item->image) }}" class="image-preview">@else<img id="banner-img-preview" class="image-preview" style="display:none;">@endif
        </div>
        <div class="form-group"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Active on website</label></div>
        <button type="submit" class="btn-adm btn-primary" data-testid="banner-save"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
