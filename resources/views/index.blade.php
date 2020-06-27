@extends('layouts.app')
@section('content')
    <article class="carousel-cont" style="margin-top: -24px;">
        <div id="carouselHome" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselHome" data-slide-to="0" class="active"></li>
                <li data-target="#carouselHome" data-slide-to="1"></li>
                <li data-target="#carouselHome" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item carousel-slide-1 active">
                    <div class="carousel-slide-cont">
                        <div>
                            <div class="col-12 col-lg-6 p-0 m-0">
                                <h4 class="font-oswald-med">WELCOME TO</h4>
                                <h2 class="font-weight-bold col-gold">DON CARLOS CITY</h2>
                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero
                                    eos et accusam et justo duo dolores et ea rebum. Stet clita
                                    kasd
                                </p>
                                <a href="">
                                    <button class="font-oswald btn btn-outline-banner px-5">EXPLORE</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item carousel-slide-1">
                    <div class="carousel-slide-cont">
                        <!-- inside a div para ma margin center ang content gamit ang flex -->
                        <div>
                            <div class="col-12 col-lg-6 p-0 m-0">
                                <h4 class="font-oswald-med">WELCOME TO</h4>
                                <h2 class="font-weight-bold col-gold">DON CARLOS CITY</h2>
                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero
                                    eos et accusam et justo duo dolores et ea rebum. Stet clita
                                    kasd
                                </p>
                                <a href="">
                                    <button class="font-oswald btn btn-outline-banner px-5">EXPLORE</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item carousel-slide-1">
                    <div class="carousel-slide-cont">
                        <!-- inside a div para ma margin center ang content gamit ang flex -->
                        <div>
                            <div class="col-12 col-lg-6 p-0 m-0">
                                <h4 class="font-oswald-med">WELCOME TO</h4>
                                <h2 class="font-weight-bold col-gold">DON CARLOS CITY</h2>
                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero
                                    eos et accusam et justo duo dolores et ea rebum. Stet clita
                                    kasd
                                </p>
                                <a href="">
                                    <button class="font-oswald btn btn-outline-banner px-5">EXPLORE</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselHome" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselHome" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </article>
    <!-- main content for home  -->
    <main class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-9">
                    <h2 class="font-oswald-bold">Plans and Programs</h2>
                    <hr class="hr-thin">
                    <div class="row no-gutters w-100 text-center">
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl p-2">
                            <button class="btn btn-home-programs py-3 px-0 shadow-sm w-100"><i
                                    class="fas fa-university fa-2x"></i><br><span class="font-weight-bold">Insfrastructure</span>
                            </button>
                        </div>
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl p-2">
                            <button class="btn btn-home-programs py-3 shadow-sm w-100"><i
                                    class="fas fa-tractor fa-2x"></i><br><span
                                    class="font-weight-bold">Agriculture</span></button>
                        </div>
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl p-2">
                            <button class="btn btn-home-programs py-3 shadow-sm w-100"><i
                                    class="fas fa-heartbeat fa-2x"></i><br><span
                                    class="font-weight-bold">Healthcare</span></button>
                        </div>
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl p-2">
                            <button class="btn btn-home-programs py-3 shadow-sm w-100"><i
                                    class="fas fa-graduation-cap fa-2x"></i><br><span
                                    class="font-weight-bold">Education</span></button>
                        </div>
                        <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl p-2">
                            <button class="btn btn-home-programs py-3 shadow-sm w-100"><i
                                    class="fas fa-plane fa-2x"></i><br><span class="font-weight-bold">Tourism</span>
                            </button>
                        </div>
                    </div>
                    <!-- the arport section -->
                    <div class="d-flex flex-column flex-md-row my-5 prog-content-container">
                        <!-- ge background nako ang image para dili mo stretch -->
                        <div class="prog-cont-image1"
                             style="background-image: url('{{ asset('assets/images/airport.jpg') }}');"></div>
                        <!-- <img src="assets/images/airport.jpg" alt=""> -->
                        <div class="text-center mt-5 mt-md-0 mx-md-4">
                            <h3 class="font-weight-bold">Don Carlos Domestic Airport</h3>
                            <hr class="hr-center-thin">
                            <p class="my-4">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                                eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At
                                vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing
                                elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
                                sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur
                                sadipscing elitr, sed diam nonumy eirmod tempor
                                invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et
                                accusam et</p>
                            <a href="#">
                                <button class="btn btn-outline-gold px-5">
                                    Learn More
                                </button>
                            </a>

                        </div>
                    </div>
                    <!-- Meet the woman to care section -->
                    <div class="bg-light px-3 py-5 d-flex flex-column flex-md-row">
                        <div class="text-center">
                            <h3 class="font-weight-bold">Meet Woman Who Care About Our City</h3>
                            <hr class="hr-center-thin">
                            <p class="my-4">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                                eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At
                                vero eos et accusam et Lorem ipsum dolor sit amet, consetetur sadipscing
                                elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
                                sed diam voluptua. At vero eos et accusam et Lorem ipsum dolor sit amet, consetetur
                                sadipscing elitr, sed diam nonumy eirmod tempor
                                invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et
                                accusam et</p>
                            <a href="#">
                                <button class="btn btn-outline-gold px-5">
                                    Learn More
                                </button>
                            </a>
                        </div>
                        <div class="ml-md-3 mt-3 mt-md-0">
                            <!-- inline image so that it can be change -->
                            <div class="prog-cont-image2"
                                 style="background-image: url('{{ asset('assets/images/doctor.png') }}');"></div>
                        </div>

                    </div>
                    <!-- services Section -->
                    <div class="my-4">
                        <h2 class="font-oswald-bold">Services</h2>
                        <hr class="hr-thin">
                        <div class="row">
                            @foreach($services as $service)
                                <div class="col-12 col-md-6 pt-2">
                                    <div class="d-flex">
                                        <div class="home-services-sect "><i
                                                class="fas fa-university fa-2x rounded-circle p-3 bg-gold col-dirtyWhite"></i>
                                        </div>
                                        <div class="pl-3">
                                            <h4 class="font-weight-bold">{{ $service->name }}</h4>
                                            <p class="col-text">{{ $service->short_description }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            <div class="text-center w-100 my-3">
                                <a href="{{ route('services') }}">
                                    <button class="btn btn-outline-gold px-5">
                                        Learn More
                                    </button>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- sidenav -->
                <div class="col-12 col-lg-3">
                    <h3 class="font-weight-bold">Don Carlos Hotline</h3>
                    <hr class="hr-thin">
                    <div class="px-2 font-weight-bold">
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-12 pt-3">
                                <h5 class="font-weight-bold">PNP:</h5>
                                <span class="pl-4">09236785946</span><br>
                                <span class="pl-4">09267854366</span>
                            </div>
                            <div class="col-12 col-md-4 col-lg-12 pt-3">
                                <h5 class="font-weight-bold">FIRE:</h5>
                                <span class="pl-4">09236785946</span><br>
                                <span class="pl-4">09267854366</span>
                            </div>
                            <div class="col-12 col-md-4 col-lg-12 pt-3">
                                <h5 class="font-weight-bold">RESCUE:</h5>
                                <span class="pl-4">09236785946</span><br>
                                <span class="pl-4">09267854366</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h2 class="font-oswald-bold">Announcement</h2>
                        <hr class="hr-thin">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-lg-12 pt-3">
                                <div class="card bg-light shadow-sm border-0">
                                    <div>
                                        <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                                        <img class="card-img max-height-150" src="assets/images/munhall2.jpg"
                                             alt="Announcement Images">
                                        <div class="bg-deepRed px-4 rounded-left text-white important-overlay">
                                            IMPORTANT
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold">2 FEB : Magkakaroon ng emergency sa
                                            pri....</h6>
                                        <p class="card-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
                                            sed diam nonumy</p>
                                        <button class="btn btn-outline-gold px-4 py-1">
                                            <small>More Info</small>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-12 pt-3">
                                <div class="card bg-light shadow-sm border-0">
                                    <div>
                                        <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                                        <img class="card-img max-height-150" src="assets/images/munhall2.jpg"
                                             alt="Announcement Images">
                                        <div class="bg-deepRed px-4 rounded-left text-white important-overlay">
                                            IMPORTANT
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold">2 FEB : Magkakaroon ng emergency sa
                                            pri....</h6>
                                        <p class="card-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
                                            sed diam nonumy</p>
                                        <button class="btn btn-outline-gold px-4 py-1">
                                            <small>More Info</small>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest New row div -->
        <div class="bg-light shadow-sm my-4">
            <div class="container py-4">
                <div class="row">
                    <div class="col-12 col-lg-3 text-center pt-3">
                        <h2 class="font-oswald-bold">Latest News</h2>
                        <hr class="hr-center-thin">
                        <p class="my-4">{{ $latestNews->short_description }}</p>
                        <a href="{{ route('news.detail', ['slug' => $latestNews->slug]) }}" class="btn btn-outline-gold px-4 py-1">
                            <small>More Info</small>
                        </a>
                    </div>

                    @foreach($news as $new)
                        <div class="col-12 col-sm-6 col-lg-3 pt-3">
                            <div class="card shadow-sm border-0 p-3">
                                <img class="card-img"
                                     src="{{ $new->avatar ? asset('/backend/uploads/articles/thumbnail/'.$new->avatar) : asset('assets/icons/images.svg') }}"
                                     style="max-height: 150px;"
                                     alt="Announcement Images">
                                <div class="d-flex flex-row">
                                    <small class="flex-fill">
                                        <i class="far fa-user-circle"></i>
                                        <span class="user pl-1">{{ $new->user->name }}</span>
                                    </small>
                                    <small>
                                        <i class="far fa-clock"></i><span
                                            class="news-date pl-1">{{ $new->created_at->diffForHumans() }}</span>
                                    </small>
                                </div>
                                <div class="mt-3">
                                    <h6 class="card-title font-weight-bold" title="{{ $new->title }}">
                                        <a href="{{ route('news.detail', ['slug' => $new->slug]) }}"
                                           class="text-dark">
                                            {{ $new->created }} : {{ $new->display_data($new->title, 50) }}
                                        </a>
                                    </h6>
                                    <p class="card-text">
                                        {{ $new->display_data($new->short_description, 140) }}
                                    </p>
                                    <a href="{{ route('news.detail', ['slug' => $new->slug]) }}" class="btn btn-outline-gold px-4 py-1">
                                        <small>Read more</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                @endforeach
                <!-- END NEWS CONTENT  -->
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <h2 class="text-center font-oswald-bold">Upcoming Events</h2>
            <hr class="hr-center-thin">
            <div class="row my-4">
                @php
                    $month = ["", 'Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sept','Oct', 'Nov', 'Dec']
                @endphp
                <div class="col-12 col-md-6 pt-3">
                    <div class="card shadow-sm border-0">
                        <a href="{{ route('event.show', ['slug' => $latestActivity->slug]) }}" class="col-darkGrey home-link-setting">
                            <div class="position-relative">
                                <img class="card-img" src="{{ $latestActivity->avatar !== null ? asset('/backend/uploads/activities/'.$latestActivity->avatar) : 'https://images.unsplash.com/photo-1573490647695-2892d0bf89e7?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=799&q=80' }}" style="max-height: 350px;"
                                     alt="Announcement Images">
                                <h5 class="event-overlay p-3 m-0 bg-gold col-dirtyWhite font-weight-bold text-center">
                                    {{ $latestActivity->display_date('day') }}
                                    <br> {{ $month[$latestActivity->display_date('month')] }} {{ $latestActivity->display_date('year') }}

                                </h5>
                            </div>
                            <div class="m-3">
                                <h5 class="card-title font-weight-bold m-0">{{ $latestActivity->title }}</h5>
                                <div class="d-flex flex-column flex-md-row ">
                                    <small><i class="far fa-clock"></i><span
                                            class="event-date pl-1">5:00 PM - 12:00 AM</span>
                                    </small>
                                    <small class="ml-md-3"><i class="fas fa-map-marker-alt"></i><span
                                            class="news-date pl-1">{{ $latestActivity->display_address }}</span>
                                    </small>
                                </div>
                                <p class="card-text mt-2">{{ $latestActivity->short_description }}</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-6 pt-3">
                    <div class="d-flex flex-column">

                        @foreach($activities as $activity)
                            <a href="{{ route('event.show', ['slug' => $activity->slug]) }}" class="home-link-setting mb-3" title="{{ $activity->id }}">
                                <div class="d-flex flex-row event-list col-darkGrey">
                                    <h5 class="font-weight-bold bg-gold px-2 py-5 text-white text-center m-0">
                                        {{ $activity->display_date('day') }}
                                        <br>
                                        {{ $month[$activity->display_date('month')] }} {{ $activity->display_date('year') }}</h5>
                                    <div class="p-2 border-top border-bottom">
                                        <h5 class="font-weight-bold mb-1">{{ $activity->title }}</h5>
                                        <div class="d-flex flex-column flex-md-row ">
                                            <small>
                                                <i class="far fa-clock"></i>
                                                <span class="event-date pl-1">
                                                    {{ $activity->make_date() }}
                                                </span>
                                            </small>
                                            <small class="ml-md-3"><i class="fas fa-map-marker-alt"></i><span
                                                    class="news-date pl-1">{{ $activity->display_address }}</span>
                                            </small>
                                        </div>
                                        <p class="mt-2">{{ $activity->short_description }} </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div><!-- end of UPCOMING EVENTS -->
                </div>
            </div>
        </div>
    </main>

@endsection
