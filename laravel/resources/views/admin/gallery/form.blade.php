@extends('admin.layout')
@section('title', $item->exists ? 'Edit Gallery Item' : 'Add Photo')
@section('content')
<div class="card">
    <div class="card-header"><h2>{{ $item->exists ? 'Edit Gallery Item' : 'Add Photo' }}</h2><a href="{{ route('admin.gallery.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.gallery.update', $item) : route('admin.gallery.store') }}">
        @csrf @if($item->exists)@method('PUT')@endif
        <div class="form-row">
            <div class="form-group"><label>Title</label><input class="form-control" name="title" value="{{ old('title', $item->title) }}"></div>
            <div class="form-group"><label>Category</label><input class="form-control" name="category" value="{{ old('category', $item->category) }}" placeholder="e.g. Facilities"></div>
        </div>
        <div class="form-group"><label>Caption</label><input class="form-control" name="caption" value="{{ old('caption', $item->caption) }}"></div>
        <div class="form-group">
            <label>Image {{ !$item->exists ? '(required)' : '' }}</label>
            <input type="file" name="image" accept="image/*" class="form-control" data-preview="gal-img">
            @if($item->image)<img id="gal-img" src="{{ $item->image }}" class="image-preview">@else<img id="gal-img" class="image-preview" style="display:none;">@endif
        </div>
        <div class="form-row">
            <div class="form-group"><label>Sort</label><input type="number" class="form-control" name="sort" value="{{ old('sort', $item->sort ?? 0) }}"></div>
            <div class="form-group" style="align-self:end;"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Show on website</label></div>
        </div>
        <button type="submit" class="btn-adm btn-primary"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
