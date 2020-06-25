@extends('layouts.app')
@section('custom')
    <style>
        ul.pagination li {
            margin-left: 10px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        ul.pagination li a, .page-item.active {
            font-size: 20px;
            color: #F9BF00;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }

        ul.pagination li a:hover {
            background-color: #F9BF00;
            color: white;
        }

        .page-item.active .page-link {
            background-color: #F9BF00 !important;
            border-color: #F9BF00;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
        }
        .about-bg-banner {
            height: 450px;
        }
    </style>
@stop
@section('content')
    <!-- inlineng the background image so it can be dynamicaly change!!!! -->
    <!-- recommended background dimension 1920 x 1280 -->
    <div class="about-bg-banner position-relative"
         style="background-image: url('{{ asset('assets/images/cabadiangan-large.jpg') }}');margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100 ">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-3">
                        <h2 class="d-inline-block py-4 font-weight-bold text-white w-75">{{ $transparent->title }}<br><span
                                class="col-gold">Transparency</span>
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
            <a href="{{ route('transparency') }}">Transparency</a>
            <span class="px-2">></span>
            <span class="">{{ $transparent->title }}</span>
        </nav>
        <hr class="hr-thin">

        <form action="/transparent/{{ $transparent->slug }}">
            <div class="input-group ml-auto" style="width: 300px;">
                <input
                    class="form-control py-2 border-right-0 border"
                    type="text" name="q" value="{{ $_GET['q'] ?? '' }}"
                    placeholder="search"
                    id="example-search-input">
                <span class="input-group-append">
                <button type="submit" class="input-group-text bg-transparent">
                    <i class="fa fa-search "></i>
                </button>
            </span>
            </div>
        </form>

        <div class="row my-4">
            <div class="col-12 col-md-3">
                <div class="d-flex flex-column">
                    @foreach($transparencies as $transparency)
                        <a href="/transparent/{{$transparency->slug}}"
                           class="about-side-nav px-4 py-2 rounded shadow-sm w-100 text-decoration-none mt-3 {{ $transparency->slug == $slug ? 'active' : '' }}">
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
                <div class="d-flex flex-column pl-lg-4">
                    @forelse($posts as $post)
                        <a href="/transparency/{{ $slug }}/article/{{$post->slug}}" class="mt-3 shadow-sm p-2 about-page-link">
                            <div class="d-flex">
                                <div class="pl-3 pt-2">
                                    <h4 class="font-weight-bold">{{ $post->name }}</h4>
                                    <!-- recommended max char length of 150 - 180*  -->
                                    <p>{{ $post->short_description }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p>Oops..No data found</p>
                    @endforelse
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection