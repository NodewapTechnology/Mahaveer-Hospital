@extends('admin.layout')
@section('title', 'Offers')
@section('content')
<div class="card">
    <div class="card-header"><h2>Offers <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2><a href="{{ route('admin.offers.create') }}" class="btn-adm btn-primary"><i class="fas fa-plus"></i> Add Offer</a></div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Title</th><th>Badge</th><th>Discount</th><th>Valid Until</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse($items as $o)
                    <tr>
                        <td><strong>{{ $o->title }}</strong><div class="text-muted" style="font-size:.82rem;">{{ Str::limit($o->short_description, 80) }}</div></td>
                        <td>{{ $o->badge }}</td>
                        <td style="color:var(--a-primary);font-weight:600;">{{ $o->discount_label }}</td>
                        <td>{{ optional($o->valid_until)->format('d M Y') }}</td>
                        <td><span class="badge badge-{{ $o->is_active ? 'success' : 'muted' }}">{{ $o->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td class="table-actions">
                            <a href="{{ route('admin.offers.edit', $o) }}" class="btn-adm btn-outline btn-sm"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.offers.destroy', $o) }}" class="d-inline" data-confirm="Delete?">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--a-muted);">No offers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
