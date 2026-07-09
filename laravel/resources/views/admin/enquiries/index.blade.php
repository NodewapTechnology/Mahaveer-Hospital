@extends('admin.layout')
@section('title', 'Appointments &amp; Enquiries')
@section('content')

{{-- Quick stats --}}
<div class="stats-grid">
    <div class="stat">
        <div class="icn"><i class="fas fa-envelope-open-text"></i></div>
        <div class="val">{{ $totalCount }}</div>
        <div class="label">Total Enquiries</div>
    </div>
    <div class="stat accent">
        <div class="icn"><i class="fas fa-calendar-check"></i></div>
        <div class="val">{{ $onlineAppointmentsCount }}</div>
        <div class="label">Online Appointments</div>
    </div>
    <div class="stat highlight">
        <div class="icn"><i class="fas fa-clock"></i></div>
        <div class="val">{{ $todayCount }}</div>
        <div class="label">Received Today</div>
    </div>
</div>

<div class="card pad-0">
    <div class="card-header">
        <div>
            <h2>All Enquiries <span class="text-muted" style="font-size:.9rem;font-weight:500;">({{ $items->total() }})</span></h2>
            <p class="text-muted" style="margin:.2rem 0 0;font-size:.85rem;">Search &amp; filter by appointment date, source or status.</p>
        </div>
    </div>

    {{-- Filter tabs (source) --}}
    <div style="padding:0 1.5rem;display:flex;gap:.4rem;flex-wrap:wrap;border-bottom:1px solid var(--a-line-soft);padding-bottom:1rem;">
        <a href="{{ route('admin.enquiries.index') }}" class="btn-adm btn-sm {{ !$source ? 'btn-primary' : 'btn-outline' }}" data-testid="tab-all"><i class="fas fa-list"></i> All</a>
        <a href="{{ route('admin.enquiries.index', ['source' => 'hero_form']) }}" class="btn-adm btn-sm {{ $source === 'hero_form' ? 'btn-primary' : 'btn-outline' }}" data-testid="tab-online-appointments"><i class="fas fa-calendar-check"></i> Online Appointments</a>
        <a href="{{ route('admin.enquiries.index', ['source' => 'contact']) }}" class="btn-adm btn-sm {{ $source === 'contact' ? 'btn-primary' : 'btn-outline' }}" data-testid="tab-contact-form"><i class="fas fa-envelope"></i> Contact Form</a>
        <a href="{{ route('admin.enquiries.index', ['range' => 'today']) }}" class="btn-adm btn-sm {{ $range === 'today' ? 'btn-primary' : 'btn-outline' }}" data-testid="tab-today"><i class="fas fa-clock"></i> Today</a>
    </div>

    {{-- Search + Date filter --}}
    <form method="GET" style="padding:1.15rem 1.5rem;display:grid;grid-template-columns:2fr 1fr 1fr auto auto;gap:.65rem;align-items:flex-end;" data-testid="enquiries-filter-form">
        @if($source)<input type="hidden" name="source" value="{{ $source }}">@endif

        <div>
            <label style="font-size:.72rem;letter-spacing:.14em;text-transform:uppercase;color:var(--a-muted);margin-bottom:.3rem;">Search</label>
            <input type="text" name="q" class="form-control" placeholder="Name, phone, email, village, district…" value="{{ $search }}" data-testid="enquiries-search-input">
        </div>

        <div>
            <label style="font-size:.72rem;letter-spacing:.14em;text-transform:uppercase;color:var(--a-muted);margin-bottom:.3rem;"><i class="fas fa-calendar-day" style="color:var(--a-accent);"></i> Appointment Date</label>
            <input type="date" name="date" class="form-control" value="{{ $date }}" data-testid="enquiries-date-filter">
        </div>

        <div>
            <label style="font-size:.72rem;letter-spacing:.14em;text-transform:uppercase;color:var(--a-muted);margin-bottom:.3rem;">Status</label>
            <select name="status" class="form-control" data-testid="enquiries-status-filter">
                <option value="">All</option>
                @foreach(['new' => 'New', 'in_progress' => 'In Progress', 'resolved' => 'Resolved', 'closed' => 'Closed'] as $k => $v)
                    <option value="{{ $k }}" @selected($status === $k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn-adm btn-primary" data-testid="enquiries-apply-filter"><i class="fas fa-filter"></i> Filter</button>
        @if($search || $status || $date || $source || $range)
            <a href="{{ route('admin.enquiries.index') }}" class="btn-adm btn-outline" data-testid="enquiries-reset"><i class="fas fa-rotate-left"></i> Reset</a>
        @else
            <span></span>
        @endif
    </form>

    @if($date || $source === 'hero_form')
        <div style="margin:0 1.5rem 1rem;padding:.75rem 1rem;background:var(--a-primary-soft);border-left:3px solid var(--a-primary);border-radius:8px;font-size:.87rem;color:var(--a-primary);">
            <i class="fas fa-info-circle"></i>
            @if($date)
                Showing bookings for <strong>{{ \Carbon\Carbon::parse($date)->format('d M Y (l)') }}</strong>
            @elseif($source === 'hero_form')
                Showing <strong>Online Appointment</strong> requests submitted via the home page form
            @endif
        </div>
    @endif

    <div class="table-wrap" style="border-radius:0;border-left:0;border-right:0;border-bottom:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Appointment&nbsp;Date</th>
                    <th>Source</th>
                    <th>Status</th>
                    <th>Received</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $e)
                    <tr data-testid="enquiry-row-{{ $e->id }}">
                        <td>
                            <strong>{{ $e->name }}</strong>
                            @if($e->email)<div class="text-muted" style="font-size:.78rem;">{{ $e->email }}</div>@endif
                        </td>
                        <td><a href="tel:{{ $e->phone }}" style="color:var(--a-accent);text-decoration:none;font-weight:600;">{{ $e->phone }}</a></td>
                        <td>
                            @if($e->village || $e->district)
                                <div style="font-weight:500;">{{ $e->village ?: '—' }}</div>
                                @if($e->district)<div class="text-muted" style="font-size:.78rem;">{{ $e->district }}</div>@endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($e->preferred_date)
                                <span class="badge badge-info" style="font-family:'Manrope',sans-serif;letter-spacing:.02em;">
                                    <i class="fas fa-calendar-day"></i> {{ \Carbon\Carbon::parse($e->preferred_date)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($e->source === 'hero_form')
                                <span class="badge badge-info"><i class="fas fa-star"></i> Online</span>
                            @else
                                <span class="badge badge-muted">{{ $e->source }}</span>
                            @endif
                        </td>
                        <td>
                            @php $b = ['new' => 'warning', 'in_progress' => 'info', 'resolved' => 'success', 'closed' => 'muted'][$e->status] ?? 'muted'; @endphp
                            <span class="badge badge-{{ $b }}">{{ ucwords(str_replace('_', ' ', $e->status)) }}</span>
                        </td>
                        <td class="text-muted" style="font-size:.82rem;">{{ $e->created_at->diffForHumans() }}</td>
                        <td class="table-actions">
                            <a href="{{ route('admin.enquiries.show', $e) }}" class="btn-adm btn-outline btn-sm" data-testid="view-enquiry-{{ $e->id }}"><i class="fas fa-eye"></i></a>
                            <form method="POST" action="{{ route('admin.enquiries.destroy', $e) }}" class="d-inline" data-confirm="Delete this enquiry?">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" style="text-align:center;padding:3rem 1.5rem;color:var(--a-muted);">
                        <i class="fas fa-inbox" style="font-size:2rem;opacity:.4;"></i>
                        <div style="margin-top:.6rem;font-weight:600;">No enquiries match your filters</div>
                        <div style="font-size:.86rem;">Try clearing the date/status filter or searching a different term.</div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:1.25rem 1.5rem;">{{ $items->links() }}</div>
</div>
@endsection
