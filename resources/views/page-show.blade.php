@extends('layouts.app')

@section('seo')
    <link rel="canonical" href="{{ route('page.show', ['slug' => $content->slug]) }}"/>
    <meta property="og:url" content="{{ route('page.show', ['slug' => $content->slug]) }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{$content->title}}"/>
    <meta property="og:image" content="{{'Don Carlos '. $content->avatar}}"/>
    <meta property="og:description" content="{{$content->short_description}}"/>
@endsection

@section('content')
    <!-- inlineng the background image so it can be dynamicaly change!!!! -->
    <!-- recommended background dimension 1920 x 1280 -->
    <div class="trending-bg-banner position-relative"
         style="background: url( {{ $content->display_image() }}) no-repeat center center / cover;margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100 ">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-3">
                        <h2 class="d-inline-block px-4 py-2 bg-gold bg-success font-oswald-bold text-white text-uppercase">
                            {{ $content->title }}
                        </h2>
                        <!-- recommended nga 48char and below and count sa title gekan sa server para dli maguba ang css -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="mt-4">
            {!! $content->description !!}
        </div>
        <br>
        <h5 class="font-oswald-bold mt-4">See More Post</h5>
        <hr class="hr-thin">
        <div class="row mb-4 mt-2">
            @forelse($relatedPosts as $post)
                <div class="col-12 col-sm-6 col-lg-4 pt-3">
                    <div class="card bg-light shadow-sm border-0">
                        <div>
                            <!-- recommended landscape image to prevent blurring in when changing screen size -->
                            <img class="card-img max-height-250"
                                 src="{{ $post->display_image() }}"
                                 alt="Announcement Images">
                        </div>
                        <div class="card-body">
                            <h4 class="font-oswald-bold text-uppercase">
                                <a href="{{ route('tourism.show', ['slug' => $post->slug]) }}"
                                   class="text-dark">{{ $post->name }}</a>
                            </h4>
                            <p class="col-gold">{{ $post->address }}</p>
                            <p class="card-text">{{ $post->short_description }}</p>
                            <a href="{{ route('tourism.show', ['slug' => $post->slug]) }}"
                               class="btn btn-outline-gold px-4 py-1 rounded-0">
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
