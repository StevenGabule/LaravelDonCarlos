@extends('layouts.app')
@section('custom')
    <style>
        .pagination {
            justify-content: center !important;
            font-weight: 700 !important;
        }

        .page-item {
            padding: 5px;
            border-radius: 25px;
        }

        .page-item a {
            border-radius: 8px;
            color: #F9BF00;
            border-color: #F9BF00;
        }

        .page-item.active span.page-link {
            background-color: #F9BF00 !important;
            color: #F5F5F5 !important;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            border-color: #F9BF00 !important;;
        }
    </style>
@stop

@section('content')
    <div class="w-100">
        <div class="position-absolute w-100">
            <div class="position-relative w-100">
                <div class="trending-bg-banner-tourism w-100"
                     style="background-image: url('{{ asset('assets/images/nature-large.jpg') }}');margin-top: -24px;">
                    <div class="tourism-bg-banner-overlay h-100 w-100">
                    </div>
                </div>
            </div>
        </div>
        <div class="container position-relative col-dirtyWhite" style="padding-top: 6%;">
            <div class=" h-100">
                <div class="col-12 col-md-6 mt-auto py-3">
                    <h4 class="font-oswald-bold">AMAZING PLACES IN</h4>
                    <h2 class="font-weight-bold col-gold">DON CARLOS</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd
                    </p>
                </div>
            </div>
            <div id="carouselTourism" class="carousel slide bg-white border-radius-1rem col-darkGrey mt-3 shadow-sm" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselTourism" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselTourism" data-slide-to="1"></li>
                    <li data-target="#carouselTourism" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner border-radius-1rem">
                    <div class="carousel-item active">
                        <div class="d-flex flex-column flex-lg-row">

                            <!-- recommended dimension 640x480 kay mau man ang image nga gi gamit -->
                            <img src="../assets/images/seaside-640x480.jpg" class="w-100 h-100" alt="kahulogan falls image">

                            <div class=" px-3 py-5">
                                <p class="col-gold mb-0">Brgy. Sinanguyan, Don Carlos, Bukidnoon</p>
                                <h2 class="font-oswald-bold">Kahulogan Falls</h2>
                                <p class="my-4">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
                                    clita kasd
                                </p>
                                <a href=""><button class="font-oswald btn btn-outline-gold px-4 rounded-0">EXPLORE</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex flex-column flex-lg-row">

                            <!-- recommended dimension 640x480 kay mau man ang image nga gi gamit -->
                            <img src="../assets/images/seaside-640x480.jpg" class="w-100 h-100" alt="kahulogan falls image">

                            <div class=" px-3 py-5">
                                <p class="col-gold mb-0">Brgy. Sinanguyan, Don Carlos, Bukidnoon</p>
                                <h2 class="font-oswald-bold">Kahulogan Falls</h2>
                                <p class="my-4">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
                                    clita kasd
                                </p>
                                <a href=""><button class="font-oswald btn btn-outline-gold px-4 rounded-0">EXPLORE</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex flex-column flex-lg-row">

                            <!-- recommended dimension 640x480 kay mau man ang image nga gi gamit -->
                            <img src="../assets/images/seaside-640x480.jpg" class="w-100 h-100" alt="kahulogan falls image">

                            <div class=" px-3 py-5">
                                <p class="col-gold mb-0">Brgy. Sinanguyan, Don Carlos, Bukidnoon</p>
                                <h2 class="font-oswald-bold">Kahulogan Falls</h2>
                                <p class="my-4">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
                                    clita kasd
                                </p>
                                <a href=""><button class="font-oswald btn btn-outline-gold px-4 rounded-0">EXPLORE</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br><br><br><br>
            <div class="col-darkGrey">

                <h2 class="font-oswald-bold text-center">Favorite Places</h2>

                <hr class="hr-center-thin">

                <div class="row my-4">
                    @forelse($places as $place)
                    <div class="col-12 col-sm-6 col-lg-4 pt-3">
                        <div class="card bg-light shadow-sm border-0">
                            <div>
                                <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                                <img class="card-img max-height-250"
                                     src="{{ $place->avatar !== null ? asset('/backend/uploads/places/original/'.$place->avatar) : asset('assets/icons/mountains.svg')  }}" alt="Announcement Images">
                            </div>
                            <div class="card-body">
                                <h4 class="font-oswald-bold text-uppercase">
                                    <a href="{{ route('tourism.show', ['slug' => $place->slug] ) }}" class="text-dark">{{ $place->name }}</a>
                                </h4>
                                <p class="col-gold">
                                    {{ $place->address }}
                                </p>
                                <p class="card-text">{{ $place->short_description }}</p>
                                <a href="{{ route('tourism.show', ['slug' => $place->slug] ) }}" class="btn btn-outline-gold px-4 py-1 rounded-0"><small>Visit Spot</small></a>
                            </div>
                        </div>
                    </div>
                    @empty
                        <p>Oops.. No data found</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- pagination Testing -->

    {{ $places->links() }}

    <!-- travelling tips html section -->
    <div class="my-4 container">
        <div class="d-flex flex-column flex-lg-row">

            <!-- recommended dimension 640x480 kay mau man ang image nga gi gamit -->
            <img src="../assets/images/adventure-640x480.jpg" class="w-100 h-100" alt="kahulogan falls image">

            <div class=" px-3 py-3">
                <h5 class="col-gold mb-0 font-weight-normal">TRAVELING TIPS</h5>
                <h2 class="font-oswald-bold text-uppercase">Things to remember when in don carlos</h2>
                <p class="my-4">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd
                </p>
                <div class="d-flex flex-column mb-4">
                    <p> <i class="fas fa-check-circle col-gold"></i><span class="pl-2">Lorem ipsum</span> </p>
                    <p> <i class="fas fa-check-circle col-gold"></i><span class="pl-2">Dolor</span> </p>
                    <p> <i class="fas fa-check-circle col-gold"></i><span class="pl-2">Sit amet</span> </p>
                    <p> <i class="fas fa-check-circle col-gold"></i><span class="pl-2">sed diam</span> </p>
                </div>
                <a href=""><button class="font-oswald btn btn-outline-gold px-4 rounded-0">EXPLORE</button></a>
            </div>
        </div>
    </div>

@endsection
