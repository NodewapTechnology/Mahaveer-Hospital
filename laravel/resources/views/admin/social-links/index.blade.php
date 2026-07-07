@extends('admin.layout')
@section('title', 'Social Links')
@section('content')
<div class="card">
    <div class="card-header"><h2>Social Media Links <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2><a href="{{ route('admin.social-links.create') }}" class="btn-adm btn-primary"><i class="fas fa-plus"></i> Add Link</a></div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Platform</th><th>Icon</th><th>URL</th><th>Sort</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse($items as $s)
                    <tr>
                        <td><strong>{{ $s->platform }}</strong></td>
                        <td><i class="{{ $s->icon }}"></i> <span class="text-muted" style="font-size:.82rem;">{{ $s->icon }}</span></td>
                        <td class="text-muted" style="max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $s->url }}</td>
                        <td>{{ $s->sort }}</td>
                        <td><span class="badge badge-{{ $s->is_active ? 'success' : 'muted' }}">{{ $s->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td class="table-actions">
                            <a href="{{ route('admin.social-links.edit', $s) }}" class="btn-adm btn-outline btn-sm"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.social-links.destroy', $s) }}" class="d-inline" data-confirm="Delete?">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--a-muted);">No social links yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
