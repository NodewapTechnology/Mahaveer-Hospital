@extends('admin.layout')
@section('title', 'Doctors')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Doctors <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2>
        <a href="{{ route('admin.doctors.create') }}" class="btn-adm btn-primary" data-testid="btn-create-doctor"><i class="fas fa-plus"></i> Add Doctor</a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Photo</th><th>Name</th><th>Designation</th><th>Qualification</th><th>Experience</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse($items as $d)
                    <tr data-testid="doctor-row-{{ $d->id }}">
                        <td>@if($d->photo)<img src="{{ asset($d->photo) }}" style="width:44px;height:44px;object-fit:cover;border-radius:50%;">@else<div style="width:44px;height:44px;border-radius:50%;background:var(--a-primary-soft);color:var(--a-primary);display:grid;place-items:center;font-weight:700;">{{ strtoupper(substr($d->name, 0, 1)) }}</div>@endif</td>
                        <td><strong>{{ $d->name }}</strong>@if($d->is_featured)<span class="badge badge-warning" style="margin-left:.4rem;">Featured</span>@endif</td>
                        <td>{{ $d->designation }}</td>
                        <td class="text-muted">{{ $d->qualification }}</td>
                        <td>{{ $d->experience }}</td>
                        <td><span class="badge badge-{{ $d->is_active ? 'success' : 'muted' }}">{{ $d->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td class="table-actions">
                            <a href="{{ route('admin.doctors.edit', $d) }}" class="btn-adm btn-outline btn-sm"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.doctors.destroy', $d) }}" class="d-inline" data-confirm="Delete this doctor?">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--a-muted);">No doctors yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
