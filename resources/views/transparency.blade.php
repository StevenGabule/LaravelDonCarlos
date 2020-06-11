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

                <div class="p-4 mt-3 border srvc-trans-links">
                    <a href="">
                        <div class="d-flex">
                            <img src="{{ asset('assets/icons/logo.svg') }}" alt="" class="w-50px">
                            <h5 class="flex-fill my-auto pl-3">Compounded Section File and Services</h5>
                            <div class="my-auto"> <i class="fas fa-arrow-right"></i></div>
                        </div>
                    </a>
                </div>
                <div class="p-4 mt-3 border srvc-trans-links">
                    <a href="">
                        <div class="d-flex">
                            <img src="{{ asset('assets/icons/logo.svg') }}" alt="" class="w-50px">
                            <h5 class="flex-fill my-auto pl-3">Compounded Section File and Services</h5>
                            <div class="my-auto"> <i class="fas fa-arrow-right"></i></div>
                        </div>
                    </a>
                </div>

            </div>
            <div class="col-12 col-md-3">
                <div class="d-none d-md-block">
                    <h4 class="font-oswald-bold mt-5">Latest Articles</h4>
                    <hr class="hr-thin">
                </div>

                <div class="row d-none d-md-block">

                    <div class="col-12 pt-3 ">
                        <div class="card bg-light shadow-sm border-0 ">
                            <div>
                                <img class="card-img max-height-150" src="{{ asset('assets/images/munhall2.jpg') }}" alt="Announcement Images ">
                            </div>
                            <div class="card-body ">
                                <h6 class="card-title font-weight-bold ">2 FEB : Magkakaroon ng emergency sa pri....</h6>
                                <p class="card-text ">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</p>
                                <button class="btn btn-outline-gold px-4 py-1 rounded-0"><small>More Info</small></button>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 pt-3 ">
                        <div class="card bg-light shadow-sm border-0 ">
                            <div>
                                <img class="card-img max-height-150" src="{{ asset('assets/images/munhall2.jpg') }}" alt="Announcement Images ">
                            </div>
                            <div class="card-body ">
                                <h6 class="card-title font-weight-bold ">2 FEB : Magkakaroon ng emergency sa pri....</h6>
                                <p class="card-text ">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy</p>
                                <button class="btn btn-outline-gold px-4 py-1 rounded-0"><small>More Info</small></button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
