@extends('admin.layout')
@section('title', 'Testimonials')
@section('content')
<div class="card">
    <div class="card-header"><h2>Testimonials <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2><a href="{{ route('admin.testimonials.create') }}" class="btn-adm btn-primary"><i class="fas fa-plus"></i> Add Testimonial</a></div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Name</th><th>Role</th><th>Quote</th><th>Rating</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse($items as $t)
                    <tr>
                        <td><strong>{{ $t->name }}</strong></td>
                        <td>{{ $t->role }}</td>
                        <td class="text-muted" style="max-width:400px;">{{ Str::limit($t->quote, 100) }}</td>
                        <td style="color:var(--a-accent);">{{ str_repeat('★', $t->rating ?? 5) }}</td>
                        <td><span class="badge badge-{{ $t->is_active ? 'success' : 'muted' }}">{{ $t->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td class="table-actions">
                            <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn-adm btn-outline btn-sm"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" class="d-inline" data-confirm="Delete?">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--a-muted);">No testimonials yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
