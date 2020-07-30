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
         style="background: url( {{ $content->avatar !== null ? $content->avatar : asset('assets/images/photo-1549880338-65ddcdfd017b.jfif')}}) no-repeat center center / cover;margin-top: -24px;">
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
        <br>
        <div>
            <div class="w-100 d-block">
                <div><p>Share with anyone:</p></div>
                <script>(function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-share-button"
                     data-href="{{ route('page.show', ['slug' => $content->slug]) }}"
                     data-layout="button_count">
                </div>
            </div>
        </div>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&autoLogAppEvents=1&version=v7.0&appId=375850583273493" nonce="GO9ViTWf"></script>

        <div class="fb-comments" data-href="https://developers.facebook.com/docs/plugins/comments#configurator" data-numposts="5" data-width=""></div>

        <h5 class="font-oswald-bold mt-4">See More Post</h5>
        <hr class="hr-thin">
        <div class="row mb-4 mt-2">
            @forelse($relatedPosts as $post)
                <div class="col-12 col-sm-6 col-lg-4 pt-3">
                    <div class="card bg-light shadow-sm border-0">
                        <div>
                            <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                            <img class="card-img max-height-250"
                                 src="{{ $post->avatar !== null ? $post->avatar : asset('assets/icons/mountains.svg') }}"
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

