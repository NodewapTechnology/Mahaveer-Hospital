@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / Gallery</div>
        <span class="overline">Photo Gallery</span>
        <h1 style="margin-top:1rem;">A glimpse inside Mahaveer Hospital.</h1>
        <p>Facilities, events, team and patient moments — captured with pride.</p>
    </div>
</section>

<section class="section">
    <div class="container-x">
        <div class="gallery-grid" data-testid="gallery-grid">
            @forelse($items as $g)
                <div class="gallery-item reveal" data-gallery-item data-src="{{ $g->image }}" data-testid="gallery-item-{{ $g->id }}">
                    <img src="{{ $g->image }}" alt="{{ $g->title }}" loading="lazy">
                    <div class="overlay">
                        <div>
                            <div class="cat">{{ $g->category }}</div>
                            <div style="margin-top:.3rem;font-family:var(--font-display);">{{ $g->title }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <p>No gallery items yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
