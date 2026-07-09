@extends('admin.layout')
@section('title', $item->exists ? 'Edit Blog' : 'New Blog')
@section('content')
<div class="card">
    <div class="card-header"><h2>{{ $item->exists ? 'Edit Blog' : 'Add Blog' }}</h2><a href="{{ route('admin.blogs.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.blogs.update', $item) : route('admin.blogs.store') }}">
        @csrf @if($item->exists)@method('PUT')@endif
        <div class="form-group"><label>Title <span class="req">*</span></label><input class="form-control" name="title" value="{{ old('title', $item->title) }}" required></div>
        <div class="form-row">
            <div class="form-group"><label>Author</label><input class="form-control" name="author" value="{{ old('author', $item->author) }}"></div>
            <div class="form-group"><label>Published Date</label><input type="date" class="form-control" name="published_at" value="{{ old('published_at', optional($item->published_at)->format('Y-m-d')) }}"></div>
        </div>
        <div class="form-group"><label>Excerpt</label><textarea class="form-control" name="excerpt" rows="2">{{ old('excerpt', $item->excerpt) }}</textarea></div>
        <div class="form-group"><label>Content (HTML supported)</label><textarea class="form-control wysiwyg" name="content" rows="10">{{ old('content', $item->content) }}</textarea></div>
        <div class="form-group">
            <label>Cover Image</label>
            <input type="file" name="cover_image" accept="image/*" class="form-control" data-preview="blg-img">
            @if($item->cover_image)<img id="blg-img" src="{{ $item->cover_image }}" class="image-preview">@else<img id="blg-img" class="image-preview" style="display:none;">@endif
        </div>
        <div class="form-group"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Publish</label></div>
        <button type="submit" class="btn-adm btn-primary"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
