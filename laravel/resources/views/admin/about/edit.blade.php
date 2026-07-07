@extends('admin.layout')
@section('title', 'About Page')

@section('content')
<div class="card">
    <div class="card-header"><h2>Edit About Page</h2></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.about.update') }}" data-testid="about-form">
        @csrf @method('PUT')
        <div class="form-row">
            <div class="form-group"><label>Overline</label><input class="form-control" name="overline" value="{{ old('overline', $item->overline) }}"></div>
            <div class="form-group"><label>Heading <span class="req">*</span></label><input class="form-control" name="heading" value="{{ old('heading', $item->heading) }}" required></div>
        </div>
        <div class="form-group"><label>Intro (short paragraph)</label><textarea class="form-control" name="intro" rows="3">{{ old('intro', $item->intro) }}</textarea></div>
        <div class="form-group"><label>Body (HTML supported)</label><textarea class="form-control" name="body" rows="8">{{ old('body', $item->body) }}</textarea></div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" accept="image/*" class="form-control" data-preview="about-img-preview">
            @if($item->image)<img id="about-img-preview" src="{{ asset($item->image) }}" class="image-preview">@else<img id="about-img-preview" class="image-preview" style="display:none;">@endif
        </div>

        <hr style="margin:1.5rem 0;border:0;border-top:1px solid var(--a-line);">
        <h3>Stats</h3>
        <div id="stats-container">
            @foreach(($item->stats ?? []) as $i => $s)
                <div class="dyn-row" style="display:grid;grid-template-columns:1fr 1fr auto;gap:.5rem;margin-bottom:.5rem;">
                    <input class="form-control" name="stats[{{ $i }}][label]" placeholder="Label" value="{{ $s['label'] ?? '' }}">
                    <input class="form-control" name="stats[{{ $i }}][value]" placeholder="Value" value="{{ $s['value'] ?? '' }}">
                    <button type="button" class="btn-adm btn-danger btn-sm" data-dyn-remove><i class="fas fa-times"></i></button>
                </div>
            @endforeach
        </div>
        <template id="stat-template"><div style="display:grid;grid-template-columns:1fr 1fr auto;gap:.5rem;margin-bottom:.5rem;"><input class="form-control" name="stats[__i__][label]" placeholder="Label"><input class="form-control" name="stats[__i__][value]" placeholder="Value"><button type="button" class="btn-adm btn-danger btn-sm" data-dyn-remove><i class="fas fa-times"></i></button></div></template>
        <button type="button" class="btn-adm btn-outline btn-sm" data-dyn-add data-dyn-target="#stats-container" data-dyn-template="#stat-template"><i class="fas fa-plus"></i> Add Stat</button>

        <hr style="margin:1.5rem 0;border:0;border-top:1px solid var(--a-line);">
        <h3>Values</h3>
        <div id="values-container">
            @foreach(($item->values ?? []) as $i => $v)
                <div class="dyn-row" style="display:grid;grid-template-columns:1fr 2fr auto;gap:.5rem;margin-bottom:.5rem;">
                    <input class="form-control" name="values[{{ $i }}][title]" placeholder="Title" value="{{ $v['title'] ?? '' }}">
                    <input class="form-control" name="values[{{ $i }}][body]" placeholder="Description" value="{{ $v['body'] ?? '' }}">
                    <button type="button" class="btn-adm btn-danger btn-sm" data-dyn-remove><i class="fas fa-times"></i></button>
                </div>
            @endforeach
        </div>
        <template id="value-template"><div style="display:grid;grid-template-columns:1fr 2fr auto;gap:.5rem;margin-bottom:.5rem;"><input class="form-control" name="values[__i__][title]" placeholder="Title"><input class="form-control" name="values[__i__][body]" placeholder="Description"><button type="button" class="btn-adm btn-danger btn-sm" data-dyn-remove><i class="fas fa-times"></i></button></div></template>
        <button type="button" class="btn-adm btn-outline btn-sm" data-dyn-add data-dyn-target="#values-container" data-dyn-template="#value-template"><i class="fas fa-plus"></i> Add Value</button>

        <div style="margin-top:2rem;"><button type="submit" class="btn-adm btn-primary" data-testid="about-save"><i class="fas fa-save"></i> Save Changes</button></div>
    </form>
</div>
@endsection
