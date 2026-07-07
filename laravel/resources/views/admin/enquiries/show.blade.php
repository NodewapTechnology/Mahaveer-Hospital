@extends('admin.layout')
@section('title', 'Enquiry #' . $item->id)
@section('content')
<div class="card">
    <div class="card-header"><h2>Enquiry #{{ $item->id }} — {{ $item->name }}</h2><a href="{{ route('admin.enquiries.index') }}" class="btn-adm btn-outline"><i class="fas fa-arrow-left"></i> Back</a></div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;">
        <div><div class="text-muted" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.14em;">Name</div><div style="font-weight:600;margin-top:.3rem;">{{ $item->name }}</div></div>
        <div><div class="text-muted" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.14em;">Phone</div><div style="font-weight:600;margin-top:.3rem;"><a href="tel:{{ $item->phone }}">{{ $item->phone }}</a></div></div>
        <div><div class="text-muted" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.14em;">Email</div><div style="font-weight:600;margin-top:.3rem;">{{ $item->email ?: '—' }}</div></div>
        <div><div class="text-muted" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.14em;">Source</div><div style="font-weight:600;margin-top:.3rem;">{{ ucfirst($item->source) }}</div></div>
        <div><div class="text-muted" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.14em;">Preferred Doctor</div><div style="font-weight:600;margin-top:.3rem;">{{ $item->preferred_doctor ?: '—' }}</div></div>
        <div><div class="text-muted" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.14em;">Preferred Date</div><div style="font-weight:600;margin-top:.3rem;">{{ $item->preferred_date ?: '—' }}</div></div>
        <div style="grid-column:1/-1;"><div class="text-muted" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.14em;">Subject</div><div style="font-weight:600;margin-top:.3rem;">{{ $item->subject ?: '—' }}</div></div>
        <div style="grid-column:1/-1;"><div class="text-muted" style="font-size:.78rem;text-transform:uppercase;letter-spacing:.14em;">Message</div><div style="margin-top:.3rem;line-height:1.7;">{{ $item->message ?: '—' }}</div></div>
    </div>

    <hr style="border:0;border-top:1px solid var(--a-line);margin:1.5rem 0;">
    <h3>Update Status</h3>
    <form method="POST" action="{{ route('admin.enquiries.update', $item) }}" style="margin-top:1rem;">
        @csrf @method('PUT')
        <div class="form-row">
            <div class="form-group"><label>Status</label>
                <select name="status" class="form-control" data-testid="enquiry-status">
                    @foreach(['new' => 'New', 'in_progress' => 'In Progress', 'resolved' => 'Resolved', 'closed' => 'Closed'] as $k => $v)
                        <option value="{{ $k }}" @selected($item->status === $k)>{{ $v }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group"><label>Admin Notes</label><textarea class="form-control" name="admin_notes" rows="4" data-testid="enquiry-notes">{{ old('admin_notes', $item->admin_notes) }}</textarea></div>
        <button type="submit" class="btn-adm btn-primary" data-testid="enquiry-update"><i class="fas fa-save"></i> Update</button>
    </form>
</div>
@endsection
