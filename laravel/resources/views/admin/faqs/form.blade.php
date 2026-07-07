@extends('admin.layout')
@section('title', $item->exists ? 'Edit FAQ' : 'New FAQ')
@section('content')
<div class="card">
    <div class="card-header"><h2>{{ $item->exists ? 'Edit FAQ' : 'Add FAQ' }}</h2><a href="{{ route('admin.faqs.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>
    @if($errors->any())<div class="alert alert-danger"><ul style="margin:0;padding-left:1.2rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ $item->exists ? route('admin.faqs.update', $item) : route('admin.faqs.store') }}">
        @csrf @if($item->exists)@method('PUT')@endif
        <div class="form-group"><label>Question <span class="req">*</span></label><input class="form-control" name="question" value="{{ old('question', $item->question) }}" required></div>
        <div class="form-group"><label>Answer <span class="req">*</span></label><textarea class="form-control" name="answer" rows="5" required>{{ old('answer', $item->answer) }}</textarea></div>
        <div class="form-row">
            <div class="form-group"><label>Sort</label><input type="number" class="form-control" name="sort" value="{{ old('sort', $item->sort ?? 0) }}"></div>
            <div class="form-group" style="align-self:end;"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))> Show on website</label></div>
        </div>
        <button type="submit" class="btn-adm btn-primary"><i class="fas fa-save"></i> Save</button>
    </form>
</div>
@endsection
