@extends('layouts.app')
@section('seo')
    <link rel="canonical" href="{{ route('news.detail', ['slug' => $news->slug]) }}"/>
    <meta property="og:url" content="{{ route('news.detail', ['slug' => $news->slug]) }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{$news->title}}"/>
    <meta property="og:image" content="{{$news->avatar}}"/>
    <meta property="og:description" content="{{$news->short_description}}"/>
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
            <div class="col-12 col-md-9">
                {!! $news->description  !!}
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
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5bdccd37bc145bb8"></script>
@endpush
