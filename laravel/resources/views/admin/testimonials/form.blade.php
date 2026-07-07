@extends('admin.layout')
@section('title', $item->exists ? 'Edit Testimonial' : 'New Testimonial')
@section('content')
<div class="card">
    <div class="card-header"><h2>{{ $item->exists ? 'Edit Testimonial' : 'Add Testimonial' }}</h2><a href="{{ route('admin.testimonials.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.testimonials.update', $item) : route('admin.testimonials.store') }}">
        @csrf @if($item->exists)@method('PUT')@endif
        <div class="form-row">
            <div class="form-group"><label>Patient/Author Name <span class="req">*</span></label><input class="form-control" name="name" value="{{ old('name', $item->name) }}" required></div>
            <div class="form-group"><label>Role / Context</label><input class="form-control" name="role" value="{{ old('role', $item->role) }}" placeholder="e.g. Gallbladder Surgery Patient"></div>
        </div>
        <div class="form-group"><label>Quote <span class="req">*</span></label><textarea class="form-control" name="quote" rows="4" required>{{ old('quote', $item->quote) }}</textarea></div>
        <div class="form-row-3">
            <div class="form-group"><label>Rating (1-5)</label><input type="number" min="1" max="5" class="form-control" name="rating" value="{{ old('rating', $item->rating ?? 5) }}"></div>
            <div class="form-group"><label>Sort</label><input type="number" class="form-control" name="sort" value="{{ old('sort', $item->sort ?? 0) }}"></div>
            <div class="form-group" style="align-self:end;"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Show on website</label></div>
        </div>
        <div class="form-group">
            <label>Photo (optional)</label>
            <input type="file" name="photo" accept="image/*" class="form-control" data-preview="tst-img">
            @if($item->photo)<img id="tst-img" src="{{ asset($item->photo) }}" class="image-preview">@else<img id="tst-img" class="image-preview" style="display:none;">@endif
        </div>
        <button type="submit" class="btn-adm btn-primary"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
