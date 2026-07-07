@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / Testimonials</div>
        <span class="overline">Patient Stories</span>
        <h1 style="margin-top:1rem;">Real voices. Real recoveries.</h1>
    </div>
</section>
<section class="section">
    <div class="container-x">
        <div class="grid-3" data-testid="testimonials-grid">
            @forelse($testimonials as $t)
                <div class="testimonial-card reveal" data-testid="testimonial-{{ $t->id }}">
                    <div class="quote-mark"><i class="fas fa-quote-left"></i></div>
                    <div class="stars">@for($i = 0; $i < ($t->rating ?? 5); $i++)<i class="fas fa-star"></i>@endfor</div>
                    <blockquote>"{{ $t->quote }}"</blockquote>
                    <div class="author"><div class="name">{{ $t->name }}</div><div class="role">{{ $t->role }}</div></div>
                </div>
            @empty
                <p>No testimonials yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
