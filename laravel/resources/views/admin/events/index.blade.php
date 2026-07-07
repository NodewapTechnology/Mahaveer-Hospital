@extends('admin.layout')
@section('title', 'Events')
@section('content')
<div class="card">
    <div class="card-header"><h2>Events <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2><a href="{{ route('admin.events.create') }}" class="btn-adm btn-primary"><i class="fas fa-plus"></i> Add Event</a></div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Title</th><th>Date</th><th>Venue</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse($items as $e)
                    <tr>
                        <td><strong>{{ $e->title }}</strong><div class="text-muted" style="font-size:.82rem;">{{ Str::limit($e->short_description, 80) }}</div></td>
                        <td>{{ $e->event_date?->format('d M Y') }} <span class="text-muted">{{ $e->event_time }}</span></td>
                        <td>{{ $e->venue }}</td>
                        <td><span class="badge badge-{{ $e->is_active ? 'success' : 'muted' }}">{{ $e->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td class="table-actions">
                            <a href="{{ route('admin.events.edit', $e) }}" class="btn-adm btn-outline btn-sm"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.events.destroy', $e) }}" class="d-inline" data-confirm="Delete?">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--a-muted);">No events yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
