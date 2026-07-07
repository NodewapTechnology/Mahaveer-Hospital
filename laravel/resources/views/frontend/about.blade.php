@extends('frontend.layout')

@section('content')
<section class="page-hero" data-testid="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / About</div>
        <span class="overline">{{ $about?->overline ?? 'About Us' }}</span>
        <h1 style="margin-top:1rem;">{{ $about?->heading ?? 'About Mahaveer Hospital' }}</h1>
        <p>{{ $about?->intro }}</p>
    </div>
</section>

<section class="section" data-testid="about-body">
    <div class="container-x">
        <div style="display:grid;grid-template-columns:1fr;gap:3rem;" class="reveal">
            <div style="font-size:1.05rem;line-height:1.8;">
                {!! $about?->body !!}
            </div>
        </div>

        @if($about?->values)
            <div class="grid-3 reveal" style="margin-top:3rem;">
                @foreach($about->values as $v)
                    <div class="card-mh">
                        <div style="width:52px;height:52px;background:var(--c-primary-soft);color:var(--c-primary);border-radius:14px;display:grid;place-items:center;font-size:1.3rem;">
                            <i class="fas fa-heart-pulse"></i>
                        </div>
                        <h3 style="margin-top:1.25rem;font-size:1.25rem;">{{ $v['title'] }}</h3>
                        <p style="margin-top:.5rem;">{{ $v['body'] }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        @if($about?->stats)
            <div class="grid-4 reveal" style="margin-top:3rem;">
                @foreach($about->stats as $s)
                    <div class="card-mh" style="text-align:center;">
                        <div style="font-family:var(--font-display);font-size:2rem;color:var(--c-accent);font-weight:700;">{{ $s['value'] }}</div>
                        <div style="margin-top:.5rem;font-size:.78rem;letter-spacing:.14em;text-transform:uppercase;color:var(--c-muted);">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
