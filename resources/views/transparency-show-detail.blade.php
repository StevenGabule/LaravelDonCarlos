@extends('layouts.app')
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
         style="background-image: url('{{ $post->avatar !== null ? asset('/backend/uploads/service-article/'.$post->avatar) : 'https://images.unsplash.com/photo-1471899236350-e3016bf1e69e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1051&q=80' }}');margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100 ">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-3">
                        <h2 class="d-inline-block py-4 font-weight-bold text-white">{{ $transparent->title }}<br><span
                                class="col-gold">TRANSPARENCY</span>
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
            <span class="px-2">&gt;</span>
            <a href="{{ route('transparency') }}">Transparency</a>
            <span class="px-2">&gt;</span>
            <a href="/transparent/{{$transparent->slug}}" class="text-capitalize">{{ $transparent->title }}</a>
            <span class="px-2">&gt;</span>
            <span>{{ $post->title }}</span>
        </nav>

        <hr class="hr-thin">

        <div class="row my-4">
            <div class="col-12 col-md-3">
                <div class="d-flex flex-column">
                    @foreach($transparencies as $transparency)
                        <a href="/transparent/{{$transparency->slug}}"
                           class="about-side-nav px-4 py-2 rounded shadow-sm w-100 text-decoration-none mt-3 {{ $transparency->slug == $slug1 ? 'active' : '' }}">
                            <p class="mb-0">{{ $transparency->title }} <i class="fas fa-arrow-right float-right pt-1"></i></p>
                        </a>
                    @endforeach
                </div>

                <div class="d-none d-md-block">
                    <h4 class="font-oswald-bold mt-5">Latest Articles</h4>
                    <hr class="hr-thin">
                </div>

                <div class="row d-none d-md-block">
                    @include('_shared._articles')
                </div>

            </div>
            <div class="col-12 col-md-9">
                <div class="pl-lg-4 pt-3">
                    <h4 class="font-oswald-bold">{{ $post->title }}</h4>
                    <hr class="hr-thin">
                    {!! $post->description !!}
                </div>
            </div>

        </div>
    </div>

@endsection
