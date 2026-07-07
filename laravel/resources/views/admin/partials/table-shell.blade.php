@extends('admin.layout')
@section('title', $title ?? 'Manage')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>{{ $heading ?? $title }} <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2>
        @isset($createRoute)
            <a href="{{ $createRoute }}" class="btn-adm btn-primary" data-testid="btn-create-new"><i class="fas fa-plus"></i> New</a>
        @endisset
    </div>
    <div class="table-wrap">
        {{ $slot }}
    </div>
</div>
@endsection
