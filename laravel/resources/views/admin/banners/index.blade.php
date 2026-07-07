@extends('admin.layout')
@section('title', 'Banners')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Banners <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2>
        <a href="{{ route('admin.banners.create') }}" class="btn-adm btn-primary" data-testid="btn-create-banner"><i class="fas fa-plus"></i> Add Banner</a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Image</th><th>Title</th><th>Badge</th><th>Sort</th><th>Status</th><th style="width:180px;"></th></tr></thead>
            <tbody>
                @forelse($items as $b)
                    <tr data-testid="banner-row-{{ $b->id }}">
                        <td>@if($b->image)<img src="{{ asset($b->image) }}" style="width:70px;height:44px;object-fit:cover;border-radius:6px;">@else<span class="text-muted">—</span>@endif</td>
                        <td><strong>{{ $b->title }}</strong>@if($b->subtitle)<div class="text-muted" style="font-size:.85rem;">{{ Str::limit($b->subtitle, 80) }}</div>@endif</td>
                        <td>{{ $b->badge ?: '—' }}</td>
                        <td>{{ $b->sort }}</td>
                        <td><span class="badge badge-{{ $b->is_active ? 'success' : 'muted' }}">{{ $b->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td class="table-actions">
                            <a href="{{ route('admin.banners.edit', $b) }}" class="btn-adm btn-outline btn-sm" data-testid="edit-banner-{{ $b->id }}"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.banners.destroy', $b) }}" class="d-inline" data-confirm="Delete this banner?">@csrf @method('DELETE')
                                <button class="btn-adm btn-danger btn-sm" data-testid="del-banner-{{ $b->id }}"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--a-muted);">No banners yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
