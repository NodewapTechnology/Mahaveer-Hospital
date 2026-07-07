@extends('admin.layout')
@section('title', 'Enquiries')
@section('content')
<div class="card">
    <div class="card-header"><h2>Enquiries <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ $items->total() }})</span></h2></div>

    <form method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.5rem;" data-testid="enquiries-search">
        <input type="text" name="q" class="form-control" style="flex:1;min-width:250px;" placeholder="Search name, phone, email, subject…" value="{{ $search }}">
        <select name="status" class="form-control" style="max-width:200px;">
            <option value="">All statuses</option>
            @foreach(['new' => 'New', 'in_progress' => 'In Progress', 'resolved' => 'Resolved', 'closed' => 'Closed'] as $k => $v)
                <option value="{{ $k }}" @selected($status === $k)>{{ $v }}</option>
            @endforeach
        </select>
        <button class="btn-adm btn-primary"><i class="fas fa-search"></i> Search</button>
        @if($search || $status)<a href="{{ route('admin.enquiries.index') }}" class="btn-adm btn-outline">Reset</a>@endif
    </form>

    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Name</th><th>Phone</th><th>Email</th><th>Subject</th><th>Source</th><th>Status</th><th>Date</th><th></th></tr></thead>
            <tbody>
                @forelse($items as $e)
                    <tr data-testid="enquiry-row-{{ $e->id }}">
                        <td><strong>{{ $e->name }}</strong></td>
                        <td>{{ $e->phone }}</td>
                        <td class="text-muted">{{ $e->email ?: '—' }}</td>
                        <td>{{ Str::limit($e->subject, 40) ?: '—' }}</td>
                        <td><span class="badge badge-info">{{ $e->source }}</span></td>
                        <td>
                            @php $b = ['new' => 'warning', 'in_progress' => 'info', 'resolved' => 'success', 'closed' => 'muted'][$e->status] ?? 'muted'; @endphp
                            <span class="badge badge-{{ $b }}">{{ ucwords(str_replace('_', ' ', $e->status)) }}</span>
                        </td>
                        <td class="text-muted">{{ $e->created_at->format('d M, H:i') }}</td>
                        <td class="table-actions">
                            <a href="{{ route('admin.enquiries.show', $e) }}" class="btn-adm btn-outline btn-sm" data-testid="view-enquiry-{{ $e->id }}">View</a>
                            <form method="POST" action="{{ route('admin.enquiries.destroy', $e) }}" class="d-inline" data-confirm="Delete?">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" style="text-align:center;padding:2rem;color:var(--a-muted);">No enquiries found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:1.5rem;">{{ $items->links() }}</div>
</div>
@endsection
