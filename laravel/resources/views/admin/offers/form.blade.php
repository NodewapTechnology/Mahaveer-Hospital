@extends('admin.layout')
@section('title', $item->exists ? 'Edit Offer' : 'New Offer')
@section('content')
<div class="card">
    <div class="card-header"><h2>{{ $item->exists ? 'Edit Offer' : 'Add Offer' }}</h2><a href="{{ route('admin.offers.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.offers.update', $item) : route('admin.offers.store') }}">
        @csrf @if($item->exists)@method('PUT')@endif
        <div class="form-group"><label>Title <span class="req">*</span></label><input class="form-control" name="title" value="{{ old('title', $item->title) }}" required></div>
        <div class="form-row">
            <div class="form-group"><label>Badge</label><input class="form-control" name="badge" value="{{ old('badge', $item->badge) }}" placeholder="e.g. Limited Time"></div>
            <div class="form-group"><label>Discount Label</label><input class="form-control" name="discount_label" value="{{ old('discount_label', $item->discount_label) }}" placeholder="e.g. 30% OFF"></div>
        </div>
        <div class="form-group"><label>Short Description</label><textarea class="form-control" name="short_description" rows="2">{{ old('short_description', $item->short_description) }}</textarea></div>
        <div class="form-group"><label>Full Description (HTML)</label><textarea class="form-control" name="description" rows="6">{{ old('description', $item->description) }}</textarea></div>
        <div class="form-row">
            <div class="form-group"><label>Valid From</label><input type="date" class="form-control" name="valid_from" value="{{ old('valid_from', optional($item->valid_from)->format('Y-m-d')) }}"></div>
            <div class="form-group"><label>Valid Until</label><input type="date" class="form-control" name="valid_until" value="{{ old('valid_until', optional($item->valid_until)->format('Y-m-d')) }}"></div>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" accept="image/*" class="form-control" data-preview="ofr-img">
            @if($item->image)<img id="ofr-img" src="{{ $item->image }}" class="image-preview">@else<img id="ofr-img" class="image-preview" style="display:none;">@endif
        </div>
        <div class="form-group"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Publish</label></div>
        <button type="submit" class="btn-adm btn-primary"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
