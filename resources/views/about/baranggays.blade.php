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
                        <h2 class="d-inline-block py-4 font-weight-bold text-white">
                            <span class="col-gold">List of Baranggay</span>
                        </h2>
                        <!-- recommended nga 48char and below and count sa title gekan sa server para dli maguba ang css -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs -->
    <div class="container">
        <nav aria-label="breadcrumb" class="about-breadcrumb h6 my-4">
            <a href="">Home</a>
            <span class="px-2">></span>
            <a href="{{ route('about') }}">About Don Carlos</a>
            <span class="px-2">></span>
            <span>List of Baranggay</span>
        </nav>

        <hr class="hr-thin">

        <form action="{{ route('about.baranggay') }}">
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
                    @include('_shared._about')
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
                    @forelse($baranggays as $baranggay)
                        <a href="{{ route('about.baranggay.detail', ['slug' => $baranggay->slug]) }}" class="mt-3 shadow-sm p-2 about-page-link">
                            <div class="d-flex">
                                <img class="card-img w-150px"
                                     src="{{ $baranggay->avatar ? asset('/backend/uploads/baranggays/'.$baranggay->avatar) : asset('assets/icons/images.svg') }}"
                                     alt="Image not found">
                                <div class="pl-3 pt-2">
                                    <h4 class="font-weight-bold">{{ $baranggay->name }}</h4>
                                    <!-- recommended max char length of 150 - 180*  -->
                                    <p>{{ $baranggay->short_description }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p>Oop... No data found</p>
                    @endforelse
                </div><!-- end of d-flex -->
                <br>
                {{ $baranggays->links() }}
            </div><!-- end of col-md-9 -->

        </div>
    </div>
@endsection
