@extends('layouts.app')

@section('seo')
    <link rel="canonical" href="{{ route('tourism.show', ['slug' => $place->slug]) }}"/>
    <meta property="og:url" content="{{ route('tourism.show', ['slug' => $place->slug]) }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{ $place->title }}"/>
    <meta property="og:image" content="{{ $place->avatar }}"/>
    <meta property="og:description" content="{{ $place->short_description }}"/>
@endsection

@section('content')
    <!-- inlining the background image so it can be dynamicaly change!!!! -->
    <!-- recommended background dimension 1920 x 1280 -->
    <div class="trending-bg-banner position-relative"
         style="background-image: url('{{ $place->avatar !== null ? $place->avatar : asset('assets/images/photo-1549880338-65ddcdfd017b.jfif') }}');margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100 ">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-3">
                        <h2 class="d-inline-block px-4 py-2 bg-gold font-oswald-bold text-white text-uppercase">{{ $place->name }}</h2>
                        <!-- recommended nga 48char and below and count sa title gekan sa server para dli maguba ang css -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="mt-4">
            <h2 class="font-oswald-bold">{{ $place->name }}</h2>
            <p><i class="fas fa-map-marker-alt"></i><span class="pl-3 font-weight-bold">{{ $place->address }}</span></p>
            {!! $place->description !!}
        </div>

        <h5 class="font-oswald-bold mt-4">Related Posts</h5>
        <hr class="hr-thin">
        <div class="row mb-4 mt-2">
            @forelse($relatedPosts as $post)
                <div class="col-12 col-sm-6 col-lg-4 pt-3">
                    <div class="card bg-light shadow-sm border-0">
                        <div>
                            <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                            <img class="card-img max-height-250" src="{{ $post->avatar !== null ? $post->avatar : asset('assets/icons/mountains.svg') }}"
                                 alt="Announcement Images">
                        </div>
                        <div class="card-body">
                            <h4 class="font-oswald-bold text-uppercase">
                                <a href="{{ route('tourism.show', ['slug' => $post->slug]) }}" class="text-dark">{{ $post->name }}</a>
                            </h4>
                            <p class="col-gold">{{ $post->address }}</p>
                            <p class="card-text">{{ $post->short_description }}</p>
                            <a href="{{ route('tourism.show', ['slug' => $post->slug]) }}" class="btn btn-outline-gold px-4 py-1 rounded-0">
                                <small>Visit Spot</small>
                            </a>
                        </div>
                    </div><!-- end of card -->
                </div>
            @empty
                <p class="ml-3">Oops...No related post.</p>
            @endforelse
        </div><!-- end of row mb-4 -->
    </div>

@endsection

@push('scripts')
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5bdccd37bc145bb8"></script>
@endpush
