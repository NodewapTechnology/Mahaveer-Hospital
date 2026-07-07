@extends('admin.layout')
@section('title', 'Services')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Services <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2>
        <a href="{{ route('admin.services.create') }}" class="btn-adm btn-primary" data-testid="btn-create-service"><i class="fas fa-plus"></i> Add Service</a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Icon</th><th>Name</th><th>Slug</th><th>Sort</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse($items as $s)
                    <tr data-testid="service-row-{{ $s->id }}">
                        <td><span style="width:40px;height:40px;background:var(--a-primary-soft);color:var(--a-primary);border-radius:8px;display:grid;place-items:center;"><i class="fas {{ $s->icon ?: 'fa-stethoscope' }}"></i></span></td>
                        <td><strong>{{ $s->name }}</strong><div class="text-muted" style="font-size:.82rem;">{{ Str::limit($s->short_description, 70) }}</div></td>
                        <td class="text-muted">{{ $s->slug }}</td>
                        <td>{{ $s->sort }}</td>
                        <td><span class="badge badge-{{ $s->is_active ? 'success' : 'muted' }}">{{ $s->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td class="table-actions">
                            <a href="{{ route('admin.services.edit', $s) }}" class="btn-adm btn-outline btn-sm"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.services.destroy', $s) }}" class="d-inline" data-confirm="Delete this service?">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--a-muted);">No services yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
