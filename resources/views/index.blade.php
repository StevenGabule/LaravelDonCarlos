@extends('layouts.app')
@section('content')
    <article class="carousel-cont">
        <div id="carouselHome" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselHome" data-slide-to="0" class="active"></li>
                <li data-target="#carouselHome" data-slide-to="1"></li>
                <li data-target="#carouselHome" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <!-- tanan image kay gi background para dili mo stretch-->
                <div class="carousel-item carousel-slide-1 active">
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
                            <div class="col-12 col-md-6 pt-2">
                                <div class="d-flex">
                                    <div class="home-services-sect "><i
                                            class="fas fa-university fa-2x rounded-circle p-3 bg-gold col-dirtyWhite"></i>
                                    </div>
                                    <div class="pl-3">
                                        <h4 class="font-weight-bold">Insfrastructure</h4>
                                        <p class="col-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                            diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
                                            sed diam voluptua. At vero eos et accusam et</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 pt-2">
                                <div class="d-flex">
                                    <div class="home-services-sect "><i
                                            class="fas fa-university fa-2x rounded-circle p-3 bg-blue col-dirtyWhite"></i>
                                    </div>
                                    <div class="pl-3">
                                        <h4 class="font-weight-bold">Insfrastructure</h4>
                                        <p class="col-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                            diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
                                            sed diam voluptua. At vero eos et accusam et</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 pt-2">
                                <div class="d-flex">
                                    <div class="home-services-sect "><i
                                            class="fas fa-university fa-2x rounded-circle p-3 bg-green col-dirtyWhite"></i>
                                    </div>
                                    <div class="pl-3">
                                        <h4 class="font-weight-bold">Insfrastructure</h4>
                                        <p class="col-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                            diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
                                            sed diam voluptua. At vero eos et accusam et</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 pt-2">
                                <div class="d-flex">
                                    <div class="home-services-sect "><i
                                            class="fas fa-university fa-2x rounded-circle p-3 bg-red col-dirtyWhite"></i>
                                    </div>
                                    <div class="pl-3">
                                        <h4 class="font-weight-bold">Insfrastructure</h4>
                                        <p class="col-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                            diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,
                                            sed diam voluptua. At vero eos et accusam et</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center w-100 my-3">
                                <a href="#">
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
                        <p class="my-4">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
                            tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et
                            accusam et</p>
                        <button class="btn btn-outline-gold px-4 py-1">
                            <small>More Info</small>
                        </button>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3 pt-3">
                        <div class="card shadow-sm border-0 p-3">
                            <img class="card-img" src="assets/images/munhall2.jpg" style="max-height: 150px;"
                                 alt="Announcement Images">
                            <div class="d-flex flex-row">
                                <small class="flex-fill"><i class="far fa-user-circle"></i> <span class="user pl-1">Admin</span>
                                </small>
                                <small><i class="far fa-clock"></i><span class="news-date pl-1">1 day ago</span>
                                </small>
                            </div>
                            <div class="mt-3">
                                <h6 class="card-title font-weight-bold">2 FEB : Magkakaroon ng emergency sa pri....</h6>
                                <p class="card-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                    nonumy</p>
                                <button class="btn btn-outline-gold px-4 py-1">
                                    <small>More Info</small>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3 pt-3">
                        <div class="card shadow-sm border-0 p-3">
                            <img class="card-img" src="assets/images/munhall2.jpg" style="max-height: 150px;"
                                 alt="Announcement Images">
                            <div class="d-flex flex-row">
                                <small class="flex-fill"><i class="far fa-user-circle"></i> <span class="user pl-1">Admin</span>
                                </small>
                                <small><i class="far fa-clock"></i><span class="news-date pl-1">1 day ago</span>
                                </small>
                            </div>
                            <div class="mt-3">
                                <h6 class="card-title font-weight-bold">2 FEB : Magkakaroon ng emergency sa pri....</h6>
                                <p class="card-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                    nonumy</p>
                                <button class="btn btn-outline-gold px-4 py-1">
                                    <small>More Info</small>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3 pt-3">
                        <div class="card shadow-sm border-0 p-3">
                            <img class="card-img" src="assets/images/munhall2.jpg" style="max-height: 150px;"
                                 alt="Announcement Images">
                            <div class="d-flex flex-row">
                                <small class="flex-fill"><i class="far fa-user-circle"></i> <span class="user pl-1">Admin</span>
                                </small>
                                <small><i class="far fa-clock"></i><span class="news-date pl-1">1 day ago</span>
                                </small>
                            </div>
                            <div class="mt-3">
                                <h6 class="card-title font-weight-bold">2 FEB : Magkakaroon ng emergency sa pri....</h6>
                                <p class="card-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                    nonumy</p>
                                <button class="btn btn-outline-gold px-4 py-1">
                                    <small>More Info</small>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <h2 class="text-center font-oswald-bold">Upcoming Events</h2>
            <hr class="hr-center-thin">
            <div class="row my-4">
                <div class="col-12 col-md-6 pt-3">
                    <div class="card shadow-sm border-0">
                        <a href="" class="col-darkGrey home-link-setting">
                            <div class="position-relative">
                                <img class="card-img" src="assets/images/band.jpg" style="max-height: 350px;"
                                     alt="Announcement Images">
                                <h5 class="event-overlay p-3 m-0 bg-gold col-dirtyWhite font-weight-bold text-center">31
                                    <br> Dec.2020</h5>
                            </div>
                            <div class="m-3">
                                <h5 class="card-title font-weight-bold m-0">Don Carlos Year end Concert</h5>
                                <div class="d-flex flex-column flex-md-row ">
                                    <small><i class="far fa-clock"></i><span
                                            class="event-date pl-1">5:00 PM - 12:00 AM</span>
                                    </small>
                                    <small class="ml-md-3"><i class="fas fa-map-marker-alt"></i><span
                                            class="news-date pl-1">Don Carlos Gym</span>
                                    </small>
                                </div>
                                <p class="card-text mt-2">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                    diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,</p>
                            </div>
                        </a>

                    </div>
                </div>
                <div class="col-12 col-md-6 pt-3">
                    <div class="d-flex flex-column">
                        <a href="" class="home-link-setting">
                            <div class="d-flex flex-row event-list col-darkGrey">
                                <h5 class="font-weight-bold bg-gold px-2 py-5 text-white text-center m-0">20 <br> April
                                    2020</h5>
                                <div class="p-2 border-top border-bottom">
                                    <h5 class="font-weight-bold mb-1">Political Conferences</h5>
                                    <div class="d-flex flex-column flex-md-row ">
                                        <small><i class="far fa-clock"></i><span class="event-date pl-1">5:00 PM - 12:00 AM</span>
                                        </small>
                                        <small class="ml-md-3"><i class="fas fa-map-marker-alt"></i><span
                                                class="news-date pl-1">Don Carlos Gym</span>
                                        </small>
                                    </div>
                                    <p class="mt-2">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                        nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                                        voluptua. At vero eos et accusam et justo duo dolores et ea rebum. </p>

                                </div>
                            </div>
                        </a>
                        <a href="" class="mt-3 home-link-setting">
                            <div class="d-flex flex-row event-list">
                                <h5 class="font-weight-bold bg-gold px-2 py-5 text-white text-center m-0">20 <br> Sept
                                    2020</h5>
                                <div class="p-2 border-top border-bottom">
                                    <h5 class="font-weight-bold mb-1">Political Conferences</h5>
                                    <div class="d-flex flex-column flex-md-row ">
                                        <small><i class="far fa-clock"></i><span class="event-date pl-1">5:00 PM - 12:00 AM</span>
                                        </small>
                                        <small class="ml-md-3"><i class="fas fa-map-marker-alt"></i><span
                                                class="news-date pl-1">Don Carlos Gym</span>
                                        </small>
                                    </div>
                                    <p class="mt-2">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                        nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                                        voluptua. At vero eos et accusam et justo duo dolores et ea rebum. </p>

                                </div>
                            </div>
                        </a>
                        <a href="" class="mt-3 home-link-setting">
                            <div class="d-flex flex-row event-list">
                                <h5 class="font-weight-bold bg-gold px-2 py-5 text-white text-center m-0">20 <br> April
                                    2020</h5>
                                <div class="p-2 border-top border-bottom">
                                    <h5 class="font-weight-bold mb-1">Political Conferences</h5>
                                    <div class="d-flex flex-column flex-md-row ">
                                        <small><i class="far fa-clock"></i><span class="event-date pl-1">5:00 PM - 12:00 AM</span>
                                        </small>
                                        <small class="ml-md-3"><i class="fas fa-map-marker-alt"></i><span
                                                class="news-date pl-1">Don Carlos Gym</span>
                                        </small>
                                    </div>
                                    <p class="mt-2">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                        nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam
                                        voluptua. At vero eos et accusam et justo duo dolores et ea rebum. </p>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
