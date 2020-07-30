@extends('layouts.app')
@section('seo')
    <link rel="canonical" href="{{ route('page.show', ['slug' => $events->slug]) }}"/>
    <meta property="og:url" content="{{ route('page.show', ['slug' => $events->slug]) }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{$events->title}}"/>
    <meta property="og:image" content="{{$events->avatar}}"/>
    <meta property="og:description" content="{{$events->short_description}}"/>
@endsection
@section('custom')
    <style>
        .trending-bg-banner {
            height: 550px;
        }
    </style>
@stop
@section('content')
    <!-- inlineng the background image so it can be dynamicaly change!!!! -->
    <!-- recommended background dimension 1920 x 1280 -->
    <div class="trending-bg-banner position-relative"
         style="background-image: url('{{ $events->display_image() }}');margin-top: -24px;">
    </div>

    <div class="container">
        <div class="mt-4">
            <h2 class="font-oswald-bold">{{ $events->title }}</h2>
            <p>
                <i class="fas fa-calendar"></i>
                <span class="font-weight-bold">
                    {{ $events->convert_date() }}
                </span>

                <span class="ml-3">
                    <i class="fas fa-map-marker-alt"></i>
                <span class="font-weight-bold">{{ $events->address }}</span>
               </span>
            </p>
            {!! $events->description !!}
            <div class="w-100 d-block mb-3 mt-3">
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
                     data-href="{{ route('event.show', ['slug' => $events->slug]) }}"
                     data-layout="button_count">
                </div>
            </div>

            <div id="disqus_thread"></div>
            <script>
                (function() { // DON'T EDIT BELOW THIS LINE
                    var d = document, s = d.createElement('script');
                    s.src = 'https://doncarlos.disqus.com/embed.js';
                    s.setAttribute('data-timestamp', +new Date());
                    (d.head || d.body).appendChild(s);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

        </div>
        <br>
        <h5 class="font-oswald-bold mt-4">Related Posts</h5>
        <hr class="hr-thin">
        <div class="row mb-4 mt-2">
            @forelse($relatedPosts as $post)
                <div class="col-12 col-sm-6 col-lg-4 pt-3">
                    <div class="card bg-light shadow-sm border-0">
                        <div>
                            <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                            <img class="card-img max-height-250"
                                 src="{{ $post->avatar !== null ? asset('/backend/uploads/activities/large/'.$post->avatar) : asset('assets/icons/mountains.svg') }}"
                                 alt="Announcement Images">
                        </div>
                        <div class="card-body">
                            <h4 class="font-oswald-bold text-uppercase">
                                <a class="text-dark" href="{{ route('event.show', ['slug' => $post->slug]) }}">
                                    {{ $post->title }}
                                </a>
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
                <p class="pl-3">Oops...No related post.</p>
            @endforelse
        </div><!-- end of row mb-4 -->
    </div>
@endsection
