@extends('admin.layout')
@section('title', 'FAQs')
@section('content')
<div class="card">
    <div class="card-header"><h2>FAQs <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2><a href="{{ route('admin.faqs.create') }}" class="btn-adm btn-primary"><i class="fas fa-plus"></i> Add FAQ</a></div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Question</th><th>Sort</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse($items as $f)
                    <tr>
                        <td><strong>{{ $f->question }}</strong><div class="text-muted" style="font-size:.82rem;">{{ Str::limit($f->answer, 120) }}</div></td>
                        <td>{{ $f->sort }}</td>
                        <td><span class="badge badge-{{ $f->is_active ? 'success' : 'muted' }}">{{ $f->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td class="table-actions">
                            <a href="{{ route('admin.faqs.edit', $f) }}" class="btn-adm btn-outline btn-sm"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $f) }}" class="d-inline" data-confirm="Delete?">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;padding:2rem;color:var(--a-muted);">No FAQs yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
