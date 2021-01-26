@extends('layouts.app')
@section('content')
    <!-- inlineng the background image so it can be dynamicaly change!!!! -->
    <!-- recommended background dimension 1920 x 1280 -->
    <div class="about-bg-banner position-relative"
         style="background-image: url('{{ asset('assets/images/cabadiangan-large.jpg') }}');margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100 ">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-3">
                        <h2 class="d-inline-block py-4 font-weight-bold text-white">About <span class="col-gold">Don Carlos</span>
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
            <a href="{{ route('about') }}">About Don Carlos</a>
            <span class="px-2">&gt;</span>
            <a href="{{ route('about.baranggay') }}">List of Baranggay</a>
            <span class="px-2">&gt;</span>
            <span>{{ $baranggay->name }}</span>
        </nav>
        <hr class="hr-thin">
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

            <div class="col-12 col-md-9 pl-lg-4 pt-3">
                <!-- recommended dimension of  a landscape 1920 x 500 or HD 1920 x 1280-->
                <div class="d-flex align-items-center">
                    <img src="{{ $baranggay->avatar !== null ? asset($baranggay->avatar) : '' }}"  alt=""
                         style="height: 74px">
                    <h2 class="font-oswald-bold">{{ $baranggay->name }}</h2>
                </div>

                <hr class="hr-thin">

                <br>

                {!! $baranggay->description !!}
                <br>

                <h5 class="font-oswald-bold mt-5">Baranggay Official</h5>
                <hr class="hr-thin">
                <div class="row">
                    {{--'1-kagawad|2-Captain|3-SK|4-Secretary|5-treasurer'--}}
                    @php
                    $position = ["", 'Kagawad', 'Punong Baranggay', 'SK Chairman', 'Secretary', 'Treasurer'];
                    @endphp
                    @forelse($officials as $official)
                        <div class="col-6 col-md-4 col-lg-3 p-2">
                            <a href="javascript:void(0)" style="cursor: default" class="about-page-link">
                                <div class="shadow-sm pb-1">
                                    <img src="{{ $official->avatar !== null ? $official->avatar : asset('assets/images/blank.png') }}"
                                         class="img-fluid" alt="">
                                    <h6 class="font-oswald-bold mt-4 px-3">{{$official->name}}</h6>
                                    <p class="font-weight-bold px-3">Baranggay {{ $position[$official->position] }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p>Oops. No data found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@stop
