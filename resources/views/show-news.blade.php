@extends('layouts.app')
@section('seo')
    <meta property="og:url" content="{{ route('news.detail', ['slug' => $news->slug]) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title"  content="{{$news->title}}" />
    <meta property="og:image" content="{{$news->avatar}}" />
    <meta property="og:description"   content="{{$news->short_description}}" />
@endsection
@section('custom')
    <style>
        .about-bg-banner {
            height: 450px;
        }
    </style>
@stop
@section('content')
    <!-- inlineng the background image so it can be dynamicaly change!!!! -->
    <!-- recommended background dimension 1920 x 1280 -->
    <div class="about-bg-banner position-relative"
         style="background: url('{{ $news->display_image() }}') no-repeat center center / cover;margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100 ">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-3">
                        <h2 class="d-inline-block py-4 font-weight-bold text-white">
                            {{ $news->title }}
                        </h2>
                        <!-- recommended nga 48char and below and count sa title gekan sa server para dli maguba ang css -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs -->
    <div class="container">
        <!-- tinanban kay para sa ako mas dali og mas sayon -->
        <nav aria-label="breadcrumb" class="about-breadcrumb h6 my-4">
            <a href="{{ route('index') }}">Home</a>
            <span class="px-2">></span>
            <a href="{{ route('news') }}">News</a>
            <span class="px-2">></span>
            <span>{{ ($news->title) }}</span>
        </nav>
        <div class="row my-4">
            <div class="col-12">
                <div class="w-100 d-block">
                    <div><p>Share with anyone:</p></div>
                    <script>(function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>
                    <div class="fb-share-button"
                         data-href="{{ route('news.detail', ['slug' => $news->slug]) }}"
                         data-layout="button_count">
                    </div>

                    <a class="twitter-share-button"
                       href="https://twitter.com/intent/tweet?text={{ $news->title }}"
                       data-size="large">
                        Tweet</a>
                </div>
            </div>
            <div class="col-12 col-md-9">
                <!-- recommended dimension of  a landscape 1920 x 500 or HD 1920 x 1280-->
                <!-- recommnded image medium dimension 1280 x 853 but blury-->
                {!! $news->description  !!}


                <br>
            </div>
            <div class="col-12 col-md-3">
                <div class="d-none d-md-block">
                    <h4 class="font-oswald-bold mt-5">Latest Articles</h4>
                    <hr class="hr-thin">
                </div>

                <div class="row d-none d-md-block">
                    @include('_shared._articles')
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')


    <!-- Your share button code -->

@endpush
