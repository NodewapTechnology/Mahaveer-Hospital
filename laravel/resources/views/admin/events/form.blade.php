@extends('admin.layout')
@section('title', $item->exists ? 'Edit Event' : 'New Event')
@section('content')
<div class="card">
    <div class="card-header"><h2>{{ $item->exists ? 'Edit Event' : 'Add New Event' }}</h2><a href="{{ route('admin.events.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.events.update', $item) : route('admin.events.store') }}">
        @csrf @if($item->exists)@method('PUT')@endif
        <div class="form-group"><label>Title <span class="req">*</span></label><input class="form-control" name="title" value="{{ old('title', $item->title) }}" required></div>
        <div class="form-row-3">
            <div class="form-group"><label>Event Date <span class="req">*</span></label><input type="date" class="form-control" name="event_date" value="{{ old('event_date', optional($item->event_date)->format('Y-m-d')) }}" required></div>
            <div class="form-group"><label>Time</label><input type="time" class="form-control" name="event_time" value="{{ old('event_time', $item->event_time) }}"></div>
            <div class="form-group"><label>Venue</label><input class="form-control" name="venue" value="{{ old('venue', $item->venue) }}"></div>
        </div>
        <div class="form-group"><label>Short Description</label><textarea class="form-control" name="short_description" rows="2">{{ old('short_description', $item->short_description) }}</textarea></div>
        <div class="form-group"><label>Full Description (HTML supported)</label><textarea class="form-control" name="description" rows="6">{{ old('description', $item->description) }}</textarea></div>
        <div class="form-group">
            <label>Cover Image</label>
            <input type="file" name="image" accept="image/*" class="form-control" data-preview="evt-img">
            @if($item->image)<img id="evt-img" src="{{ $item->image }}" class="image-preview">@else<img id="evt-img" class="image-preview" style="display:none;">@endif
        </div>
        <div class="form-group"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Publish this event</label></div>
        <button type="submit" class="btn-adm btn-primary"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
