@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat" data-testid="stat-enquiries">
        <div class="icn"><i class="fas fa-envelope-open-text"></i></div>
        <div class="val">{{ $counts['enquiries'] }}</div>
        <div class="label">Total Enquiries</div>
        @if($counts['new_enquiries'])
            <div style="margin-top:.5rem;"><span class="badge badge-warning">{{ $counts['new_enquiries'] }} new</span></div>
        @endif
    </div>
    <div class="stat" data-testid="stat-doctors"><div class="icn"><i class="fas fa-user-doctor"></i></div><div class="val">{{ $counts['doctors'] }}</div><div class="label">Doctors</div></div>
    <div class="stat" data-testid="stat-services"><div class="icn"><i class="fas fa-hand-holding-medical"></i></div><div class="val">{{ $counts['services'] }}</div><div class="label">Services</div></div>
    <div class="stat" data-testid="stat-events"><div class="icn"><i class="fas fa-calendar-days"></i></div><div class="val">{{ $counts['events'] }}</div><div class="label">Events</div></div>
    <div class="stat" data-testid="stat-testimonials"><div class="icn"><i class="fas fa-comment-medical"></i></div><div class="val">{{ $counts['testimonials'] }}</div><div class="label">Testimonials</div></div>
    <div class="stat" data-testid="stat-offers"><div class="icn"><i class="fas fa-tag"></i></div><div class="val">{{ $counts['offers'] }}</div><div class="label">Offers</div></div>
    <div class="stat" data-testid="stat-blogs"><div class="icn"><i class="fas fa-newspaper"></i></div><div class="val">{{ $counts['blogs'] }}</div><div class="label">Blogs</div></div>
    <div class="stat" data-testid="stat-gallery"><div class="icn"><i class="fas fa-image"></i></div><div class="val">{{ $counts['gallery'] }}</div><div class="label">Gallery Items</div></div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Latest Enquiries</h2>
        <a href="{{ route('admin.enquiries.index') }}" class="btn-adm btn-outline btn-sm">View All <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Name</th><th>Phone</th><th>Subject</th><th>Status</th><th>Received</th><th></th></tr></thead>
            <tbody>
                @forelse($latestEnquiries as $e)
                    <tr data-testid="dash-enquiry-{{ $e->id }}">
                        <td>{{ $e->name }}</td>
                        <td>{{ $e->phone }}</td>
                        <td>{{ $e->subject ?: '—' }}</td>
                        <td>
                            @php $badge = ['new' => 'warning', 'in_progress' => 'info', 'resolved' => 'success', 'closed' => 'muted'][$e->status] ?? 'muted'; @endphp
                            <span class="badge badge-{{ $badge }}">{{ ucwords(str_replace('_', ' ', $e->status)) }}</span>
                        </td>
                        <td class="text-muted">{{ $e->created_at->diffForHumans() }}</td>
                        <td><a href="{{ route('admin.enquiries.show', $e) }}" class="btn-adm btn-outline btn-sm">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--a-muted);padding:2rem;">No enquiries yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
