@extends('admin.layout')
@section('title', 'Blogs')
@section('content')
<div class="card">
    <div class="card-header"><h2>Blogs / News <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2><a href="{{ route('admin.blogs.create') }}" class="btn-adm btn-primary"><i class="fas fa-plus"></i> Add Blog</a></div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Title</th><th>Author</th><th>Published</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse($items as $b)
                    <tr>
                        <td><strong>{{ $b->title }}</strong><div class="text-muted" style="font-size:.82rem;">{{ Str::limit($b->excerpt, 90) }}</div></td>
                        <td>{{ $b->author }}</td>
                        <td>{{ optional($b->published_at)->format('d M Y') }}</td>
                        <td><span class="badge badge-{{ $b->is_active ? 'success' : 'muted' }}">{{ $b->is_active ? 'Published' : 'Draft' }}</span></td>
                        <td class="table-actions">
                            <a href="{{ route('admin.blogs.edit', $b) }}" class="btn-adm btn-outline btn-sm"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.blogs.destroy', $b) }}" class="d-inline" data-confirm="Delete?">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--a-muted);">No blogs yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
