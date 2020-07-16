@extends('layouts.app')
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
        </div>
        <br>
        <div>
            <div><p>Share with anyone:</p></div>
            <div class="addthis_inline_share_toolbox"></div>
        </div>
        <br>
        <br>
        <h5 class="font-oswald-bold mt-4">Related Posts</h5>
        <hr class="hr-thin">
        <div class="row mb-4 mt-2">
            @forelse($relatedPosts as $post)
                <div class="col-12 col-sm-6 col-lg-4 pt-3">
                    <div class="card bg-light shadow-sm border-0">
                        <div>
                            <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                            <img class="card-img max-height-250" src="{{ $post->avatar !== null ? asset('/backend/uploads/activities/large/'.$post->avatar) : asset('assets/icons/mountains.svg') }}"
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
                            <a href="{{ route('tourism.show', ['slug' => $post->slug]) }}" class="btn btn-outline-gold px-4 py-1 rounded-0">
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
