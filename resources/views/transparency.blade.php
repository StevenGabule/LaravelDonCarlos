@extends('layouts.app')
@section('content')
    <div class="about-bg-banner position-relative" style="background: url({{ asset('../assets/images/calling.jpg') }});margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-3">
                        <h2 class="d-inline-block py-4 font-weight-bold text-white text-uppercase">Transparency</h2>
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
            <a href="">Transparency</a>
        </nav>
        <hr class="hr-thin">
        <div class="row my-4">
            <div class="col-12 col-md-9 pr-lg-5 pt-3">
                @forelse($transparencies as $transparent)
                <div class="p-4 mt-3 border srvc-trans-links">
                    <a href="/transparent/{{$transparent->slug}}">
                        <div class="d-flex">
                            <img src="{{ asset('assets/icons/logo.svg') }}" alt="" class="w-50px">
                            <h5 class="flex-fill my-auto pl-3">{{ $transparent->title }}</h5>
                            <div class="my-auto"> <i class="fas fa-arrow-right"></i></div>
                        </div>
                    </a>
                </div>
                @empty
                    <p>Oops..No data found...</p>
                @endforelse

            </div><!-- end of col-12 col-md-9 -->
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
@endsection
