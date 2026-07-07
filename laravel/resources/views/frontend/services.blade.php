@extends('frontend.layout')

@section('content')
<section class="page-hero">
    <div class="container-x">
        <div class="crumbs"><a href="{{ url('/') }}">Home</a> / Services</div>
        <span class="overline">Specialities</span>
        <h1 style="margin-top:1rem;">Complete healthcare, under one roof.</h1>
        <p>Explore our range of clinical services, from advanced surgery to preventive check-ups.</p>
    </div>
</section>

<section class="section">
    <div class="container-x">
        <div class="grid-3" data-testid="services-grid">
            @forelse($services as $i => $s)
                <a href="{{ route('services.show', $s->slug) }}" class="service-card reveal" style="text-decoration:none;color:inherit;" data-testid="service-{{ $s->slug }}">
                    <div class="card-body">
                        <div class="num">0{{ $i + 1 }}</div>
                        <div class="icon-box"><i class="fas {{ $s->icon ?: 'fa-stethoscope' }}"></i></div>
                        <h3>{{ $s->name }}</h3>
                        <p class="desc">{{ $s->short_description }}</p>
                        @if(!empty($s->features))
                            <ul>
                                @foreach(array_slice($s->features, 0, 4) as $f)
                                    <li>{{ $f }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <span class="footer-link">Learn more <i class="fas fa-arrow-right" style="font-size:.7rem;"></i></span>
                    </div>
                </a>
            @empty
                <p>No services available yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
