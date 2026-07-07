@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / Blog</div>
        <span class="overline">Health Blog</span>
        <h1 style="margin-top:1rem;">Expert advice from our doctors.</h1>
    </div>
</section>
<section class="section">
    <div class="container-x">
        <div class="grid-3" data-testid="blogs-grid">
            @forelse($blogs as $b)
                <a href="{{ route('blogs.show', $b->slug) }}" class="blog-card reveal" style="text-decoration:none;color:inherit;" data-testid="blog-{{ $b->slug }}">
                    @if($b->cover_image)<div class="cover"><img src="{{ $b->cover_image }}" alt="{{ $b->title }}"></div>@endif
                    <div class="body">
                        <div class="meta">{{ $b->author }} · {{ optional($b->published_at)->format('d M Y') }}</div>
                        <h3>{{ $b->title }}</h3>
                        <p>{{ $b->excerpt }}</p>
                        <span class="read-more">Read article <i class="fas fa-arrow-right" style="font-size:.7rem;"></i></span>
                    </div>
                </a>
            @empty
                <p>No articles yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
