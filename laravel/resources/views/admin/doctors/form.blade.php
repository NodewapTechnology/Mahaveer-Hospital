@extends('admin.layout')
@section('title', $item->exists ? 'Edit Doctor' : 'New Doctor')

@section('content')
<div class="card">
    <div class="card-header"><h2>{{ $item->exists ? 'Edit Doctor Profile' : 'Add New Doctor' }}</h2><a href="{{ route('admin.doctors.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.doctors.update', $item) : route('admin.doctors.store') }}" data-testid="doctor-form">
        @csrf @if($item->exists)@method('PUT')@endif
        <div class="form-row">
            <div class="form-group"><label>Doctor Name <span class="req">*</span></label><input class="form-control" name="name" value="{{ old('name', $item->name) }}" required data-testid="doctor-name"></div>
            <div class="form-group"><label>Designation</label><input class="form-control" name="designation" value="{{ old('designation', $item->designation) }}" placeholder="e.g. Senior Consultant"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Qualification</label><input class="form-control" name="qualification" value="{{ old('qualification', $item->qualification) }}" placeholder="e.g. MBBS, MS, FMAS"></div>
            <div class="form-group"><label>Experience</label><input class="form-control" name="experience" value="{{ old('experience', $item->experience) }}" placeholder="e.g. 15 years"></div>
        </div>
        <div class="form-group"><label>Specialization</label><input class="form-control" name="specialization" value="{{ old('specialization', $item->specialization) }}"></div>
        <div class="form-group"><label>Description / Bio</label><textarea class="form-control wysiwyg" name="description" rows="5">{{ old('description', $item->description) }}</textarea></div>
        <div class="form-row">
            <div class="form-group"><label>Available Timing</label><input class="form-control" name="available_timing" value="{{ old('available_timing', $item->available_timing) }}" placeholder="Mon–Sat 10AM – 8PM"></div>
            <div class="form-group"><label>Contact Phone</label><input class="form-control" name="contact_phone" value="{{ old('contact_phone', $item->contact_phone) }}"></div>
        </div>
        <div class="form-group"><label>Contact Email</label><input type="email" class="form-control" name="contact_email" value="{{ old('contact_email', $item->contact_email) }}"></div>
        <div class="form-group">
            <label>Photo</label>
            <input type="file" name="photo" accept="image/*" class="form-control" data-preview="doc-img">
            @if($item->photo)<img id="doc-img" src="{{ asset($item->photo) }}" class="image-preview">@else<img id="doc-img" class="image-preview" style="display:none;">@endif
        </div>
        <div class="form-row-3">
            <div class="form-group"><label>Sort</label><input type="number" class="form-control" name="sort" value="{{ old('sort', $item->sort ?? 0) }}"></div>
            <div class="form-group" style="align-self:end;"><label class="form-check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $item->is_featured)) data-testid="doctor-featured"> Featured (only one)</label></div>
            <div class="form-group" style="align-self:end;"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Active</label></div>
        </div>
        <button type="submit" class="btn-adm btn-primary" data-testid="doctor-save"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
