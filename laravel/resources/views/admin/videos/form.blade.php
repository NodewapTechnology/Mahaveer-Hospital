@extends('admin.layout')
@section('title', $item->exists ? 'Edit Video Link' : 'New Video Link')
@section('content')
<div class="card">
    <div class="card-header"><h2>{{ $item->exists ? 'Edit Video Link' : 'Add Video Link' }}</h2><a href="{{ route('admin.videos.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ $item->exists ? route('admin.videos.update', $item) : route('admin.videos.store') }}">
        @csrf @if($item->exists)@method('PUT')@endif
        <div class="form-row">
            <div class="form-group">
                <label>Platform <span class="req">*</span></label>
                <select name="platform" class="form-control" data-testid="video-platform" required>
                    <option value="instagram" @selected(old('platform', $item->platform) === 'instagram')>Instagram (multiple allowed)</option>
                    <option value="youtube" @selected(old('platform', $item->platform) === 'youtube')>YouTube</option>
                </select>
            </div>
            <div class="form-group"><label>Title (optional)</label><input class="form-control" name="title" value="{{ old('title', $item->title) }}" placeholder="e.g. Patient success story" data-testid="video-title"></div>
        </div>
        <div class="form-group">
            <label>Video URL <span class="req">*</span></label>
            <input class="form-control" name="url" value="{{ old('url', $item->url) }}" placeholder="https://www.instagram.com/reel/... or https://youtu.be/..." required data-testid="video-url">
            <div class="form-help">Paste an Instagram reel/post link or a YouTube video link.</div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Sort Order</label><input type="number" class="form-control" name="sort" value="{{ old('sort', $item->sort ?? 0) }}" data-testid="video-sort"></div>
            <div class="form-group" style="align-self:end;"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true)) data-testid="video-active"> Show on website</label></div>
        </div>
        <button type="submit" class="btn-adm btn-primary" data-testid="save-video"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
