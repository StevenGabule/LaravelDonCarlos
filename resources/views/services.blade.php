@extends('layouts.app')

@section('content')
    <div class="about-bg-banner position-relative"
         style="background: url('{{ asset('assets/images/photo-1502781252888-9143ba7f074e.jfif') }}') no-repeat center center / cover;margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-3">
                        <h2 class="d-inline-block py-4 font-weight-bold text-white text-uppercase">Services</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs -->
    <div class="container">
        <nav aria-label="breadcrumb" class="about-breadcrumb h6 my-4">
            <a href="{{ route('index') }}">Home</a>
            <span class="px-2">></span>
            <span>Services</span>
        </nav>
        <hr class="hr-thin">
        <div class="row my-4">
            <div class="col-12 col-md-9 pr-lg-5 pt-3">

                @forelse($services as $service)
                    <div class="p-4 mt-3 border srvc-trans-links">
                        <a href="{{ route('services.show', ['id' => $service->id]) }}">
                            <div class="d-flex">
                                <img src="{{ asset('assets/icons/logo.svg') }}" alt="" class="w-50px">
                                <h5 class="flex-fill my-auto pl-3">
                                    {{ $service->name }}
                                </h5>
                                <div class="my-auto"><i class="fas fa-arrow-right"></i></div>
                            </div>
                        </a>
                    </div>
                    @empty
                        <p>No data found...</p>
                @endforelse
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
@endsection
