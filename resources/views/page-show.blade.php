@extends('layouts.app')
@section('content')
    <!-- inlineng the background image so it can be dynamicaly change!!!! -->
    <!-- recommended background dimension 1920 x 1280 -->
    <div class="trending-bg-banner position-relative"
         style="background: url( {{ $content->avatar !== null ? asset('/backend/uploads/page-content/large/'.$content->avatar)  : 'https://images.unsplash.com/photo-1549880338-65ddcdfd017b?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80'}}) no-repeat center center / cover;margin-top: -24px;">
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
            <div><p>Share with anyone:</p></div>
            <div class="addthis_inline_share_toolbox"></div>
        </div>
        <br>
        <br>

        <h5 class="font-oswald-bold mt-4">See More Post</h5>
        <hr class="hr-thin">
        <div class="row mb-4 mt-2">
            @forelse($relatedPosts as $post)
                <div class="col-12 col-sm-6 col-lg-4 pt-3">
                    <div class="card bg-light shadow-sm border-0">
                        <div>
                            <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                            <img class="card-img max-height-250"
                                 src="{{ $post->avatar !== null ? asset('/backend/uploads/places/original/'.$post->avatar) : asset('assets/icons/mountains.svg') }}"
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

