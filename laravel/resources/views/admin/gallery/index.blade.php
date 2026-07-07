@extends('admin.layout')
@section('title', 'Gallery')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Gallery <span class="text-muted" style="font-size:.85rem;font-weight:500;">({{ count($items) }})</span></h2>
        <a href="{{ route('admin.gallery.create') }}" class="btn-adm btn-primary"><i class="fas fa-plus"></i> Add Photo</a>
    </div>
    <div style="padding:1.5rem;">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;">
            @forelse($items as $g)
                <div style="background:#fff;border:1px solid var(--a-line);border-radius:12px;overflow:hidden;" data-testid="gallery-tile-{{ $g->id }}">
                    <div style="aspect-ratio:1;overflow:hidden;"><img src="{{ $g->image }}" style="width:100%;height:100%;object-fit:cover;"></div>
                    <div style="padding:.75rem;">
                        <div style="font-weight:600;font-size:.9rem;">{{ Str::limit($g->title, 30) }}</div>
                        <div class="text-muted" style="font-size:.78rem;">{{ $g->category }}</div>
                        <div style="margin-top:.6rem;display:flex;gap:.35rem;">
                            <a href="{{ route('admin.gallery.edit', $g) }}" class="btn-adm btn-outline btn-sm" style="flex:1;justify-content:center;"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.gallery.destroy', $g) }}" class="d-inline" data-confirm="Delete?" style="flex:1;">@csrf @method('DELETE')<button class="btn-adm btn-danger btn-sm" style="width:100%;justify-content:center;"><i class="fas fa-trash"></i></button></form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted" style="grid-column:1/-1;text-align:center;padding:2rem;">No photos in gallery yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
