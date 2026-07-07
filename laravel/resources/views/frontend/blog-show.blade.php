@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / <a href="{{ route('blogs') }}">Blog</a> / {{ $blog->title }}</div>
    </div>
</section>
<section class="section">
    <div class="container-x" style="max-width:840px;margin:0 auto;">
        @if($blog->cover_image)<img src="{{ $blog->cover_image }}" alt="{{ $blog->title }}" style="width:100%;border-radius:var(--radius-lg);margin-bottom:2rem;">@endif
        <div style="color:var(--c-muted);text-transform:uppercase;letter-spacing:.14em;font-size:.78rem;">{{ $blog->author }} · {{ optional($blog->published_at)->format('d M Y') }}</div>
        <h1 style="margin-top:1rem;">{{ $blog->title }}</h1>
        <p style="margin-top:1rem;font-size:1.15rem;color:var(--c-ink-soft);">{{ $blog->excerpt }}</p>
        <div style="margin-top:2rem;font-size:1.02rem;line-height:1.85;">{!! $blog->content !!}</div>
    </div>
    @if($related->count())
        <div class="container-x" style="margin-top:4rem;">
            <h3 style="margin-bottom:1.5rem;">Related Articles</h3>
            <div class="grid-3">
                @foreach($related as $r)
                    <a href="{{ route('blogs.show', $r->slug) }}" class="blog-card" style="text-decoration:none;color:inherit;">
                        @if($r->cover_image)<div class="cover"><img src="{{ $r->cover_image }}" alt=""></div>@endif
                        <div class="body">
                            <div class="meta">{{ optional($r->published_at)->format('d M Y') }}</div>
                            <h3>{{ $r->title }}</h3>
                            <p>{{ $r->excerpt }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</section>
@endsection
