@extends('admin.layout')
@section('title', ($item->exists ? 'Edit' : 'Add') . ' Translation')
@section('content')
<div class="card" style="max-width:760px;">
    <div class="card-header">
        <h2>{{ $item->exists ? 'Edit' : 'Add' }} Translation</h2>
        <a href="{{ route('admin.translations.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
    </div>

    <form method="POST" action="{{ $item->exists ? route('admin.translations.update', $item) : route('admin.translations.store') }}" style="padding:1.25rem;">
        @csrf
        @if($item->exists) @method('PUT') @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0;padding-left:1.25rem;">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="form-row">
            <div>
                <label>Key <span style="color:#dc2626;">*</span></label>
                <input type="text" name="key" value="{{ old('key', $item->key) }}" class="form-control-adm" placeholder="e.g. nav.home" required data-testid="tr-key">
                <small class="text-muted">Unique identifier used in code. Format: group.name</small>
            </div>
            <div>
                <label>Group</label>
                <input type="text" name="group" value="{{ old('group', $item->group ?: 'general') }}" class="form-control-adm" placeholder="nav, cta, label..." data-testid="tr-group">
            </div>
        </div>

        <div class="form-row">
            <div>
                <label>English Value <span style="color:#dc2626;">*</span></label>
                <input type="text" name="en_value" value="{{ old('en_value', $item->en_value) }}" class="form-control-adm" required data-testid="tr-en">
            </div>
            <div>
                <label>Hindi Value (हिन्दी)</label>
                <input type="text" name="hi_value" value="{{ old('hi_value', $item->hi_value) }}" class="form-control-adm" style="font-family:'Noto Sans Devanagari','Manrope',sans-serif;" data-testid="tr-hi">
            </div>
        </div>

        <div>
            <label>Notes (optional)</label>
            <textarea name="note" class="form-control-adm" rows="2" placeholder="Where this label appears..." data-testid="tr-note">{{ old('note', $item->note) }}</textarea>
        </div>

        <div style="margin-top:1.5rem;display:flex;gap:.6rem;">
            <button type="submit" class="btn-adm btn-primary" data-testid="tr-save"><i class="fas fa-save"></i> Save</button>
            <a href="{{ route('admin.translations.index') }}" class="btn-adm btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
