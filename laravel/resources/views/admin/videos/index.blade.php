@extends('admin.layout')
@section('title', 'Video Links')
@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h2>Video Links <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2>
            <p class="text-muted" style="margin:.2rem 0 0;font-size:.85rem;">Add multiple Instagram reels &amp; a YouTube video. They appear as previews on the home page and open the platform on click.</p>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="btn-adm btn-primary" data-testid="add-video-link"><i class="fas fa-plus"></i> Add Video Link</a>
    </div>
    <div class="table-wrap">
        <table class="table">
            <thead><tr><th>Platform</th><th>Title</th><th>URL</th><th>Sort</th><th>Status</th><th></th></tr></thead>
            <tbody>
                @forelse($items as $v)
                    <tr data-testid="video-row-{{ $v->id }}">
                        <td>
                            @if($v->platform === 'youtube')
                                <span class="badge badge-danger"><i class="fab fa-youtube"></i> YouTube</span>
                            @else
                                <span class="badge badge-info"><i class="fab fa-instagram"></i> Instagram</span>
                            @endif
                        </td>
                        <td>{{ $v->title ?: '—' }}</td>
                        <td class="text-muted" style="max-width:320px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><a href="{{ $v->url }}" target="_blank" rel="noopener">{{ $v->url }}</a></td>
                        <td>{{ $v->sort }}</td>
                        <td><span class="badge badge-{{ $v->is_active ? 'success' : 'muted' }}">{{ $v->is_active ? 'Active' : 'Hidden' }}</span></td>
                        <td class="table-actions">
                            <a href="{{ route('admin.videos.edit', $v) }}" class="btn-adm btn-outline btn-sm" data-testid="edit-video-{{ $v->id }}"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.videos.destroy', $v) }}" class="d-inline" data-confirm="Delete this video link?">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm" data-testid="delete-video-{{ $v->id }}"><i class="fas fa-trash"></i></button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;padding:2.5rem;color:var(--a-muted);">
                        <i class="fas fa-film" style="font-size:1.8rem;opacity:.4;"></i>
                        <div style="margin-top:.6rem;font-weight:600;">No video links yet</div>
                        <div style="font-size:.86rem;">Add an Instagram reel or a YouTube video to feature it on the home page.</div>
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
