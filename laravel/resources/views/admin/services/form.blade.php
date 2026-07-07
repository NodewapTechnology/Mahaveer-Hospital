@extends('admin.layout')
@section('title', $item->exists ? 'Edit Service' : 'New Service')

@section('content')
<div class="card">
    <div class="card-header"><h2>{{ $item->exists ? 'Edit Service' : 'Add New Service' }}</h2><a href="{{ route('admin.services.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.services.update', $item) : route('admin.services.store') }}" data-testid="service-form">
        @csrf @if($item->exists)@method('PUT')@endif
        <div class="form-row">
            <div class="form-group"><label>Name <span class="req">*</span></label><input class="form-control" name="name" value="{{ old('name', $item->name) }}" required data-testid="service-name"></div>
            <div class="form-group"><label>Icon (Font Awesome class, e.g. fa-scissors)</label><input class="form-control" name="icon" value="{{ old('icon', $item->icon) }}"></div>
        </div>
        <div class="form-group"><label>Short Description</label><textarea class="form-control" name="short_description" rows="2">{{ old('short_description', $item->short_description) }}</textarea></div>
        <div class="form-group"><label>Full Description (HTML supported)</label><textarea class="form-control" name="description" rows="6">{{ old('description', $item->description) }}</textarea></div>
        <div class="form-group">
            <label>Features / Highlights</label>
            <div id="features-container">
                @foreach(($item->features ?? []) as $i => $f)
                    <div class="dyn-row" style="display:flex;gap:.5rem;margin-bottom:.5rem;"><input class="form-control" name="features[]" value="{{ $f }}"><button type="button" class="btn-adm btn-danger btn-sm" data-dyn-remove><i class="fas fa-times"></i></button></div>
                @endforeach
            </div>
            <template id="feature-template"><div style="display:flex;gap:.5rem;margin-bottom:.5rem;"><input class="form-control" name="features[]" placeholder="e.g. Gallbladder Removal"><button type="button" class="btn-adm btn-danger btn-sm" data-dyn-remove><i class="fas fa-times"></i></button></div></template>
            <button type="button" class="btn-adm btn-outline btn-sm" data-dyn-add data-dyn-target="#features-container" data-dyn-template="#feature-template"><i class="fas fa-plus"></i> Add Feature</button>
        </div>
        <div class="form-group">
            <label>Image (optional)</label>
            <input type="file" name="image" accept="image/*" class="form-control" data-preview="svc-img">
            @if($item->image)<img id="svc-img" src="{{ asset($item->image) }}" class="image-preview">@else<img id="svc-img" class="image-preview" style="display:none;">@endif
        </div>
        <div class="form-row">
            <div class="form-group"><label>Sort</label><input type="number" class="form-control" name="sort" value="{{ old('sort', $item->sort ?? 0) }}"></div>
            <div class="form-group" style="align-self:end;"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Active</label></div>
        </div>
        <button type="submit" class="btn-adm btn-primary" data-testid="service-save"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
