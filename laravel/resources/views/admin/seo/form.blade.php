@extends('admin.layout')
@section('title', 'Edit SEO')
@section('content')
<div class="card">
    <div class="card-header"><h2>SEO — {{ ucfirst($item->page_key) }} page</h2><a href="{{ route('admin.seo-settings.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.seo-settings.update', $item) }}">
        @csrf @method('PUT')
        <div class="form-group"><label>Meta Title</label><input class="form-control" name="title" value="{{ old('title', $item->title) }}"></div>
        <div class="form-group"><label>Meta Description</label><textarea class="form-control" name="description" rows="3">{{ old('description', $item->description) }}</textarea></div>
        <div class="form-group"><label>Keywords (comma-separated)</label><textarea class="form-control" name="keywords" rows="2">{{ old('keywords', $item->keywords) }}</textarea></div>
        <div class="form-group">
            <label>OG Image</label>
            <input type="file" name="og_image" accept="image/*" class="form-control" data-preview="og-img">
            @if($item->og_image)<img id="og-img" src="{{ asset($item->og_image) }}" class="image-preview">@else<img id="og-img" class="image-preview" style="display:none;">@endif
        </div>
        <button type="submit" class="btn-adm btn-primary"><i class="fas fa-save"></i> Save SEO</button>
    </form>
</div>
@endsection
