@extends('layouts.app')
@section('content')
    <div class="trending-bg-banner-tourism position-relative" style="background-image: url('assets/images/band-large.jpg'); margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100 ">
            <div class="container col-dirtyWhite h-100">
                <div class="col-12 col-md-6 h-100">
                    <div class="d-flex h-100">
                        <div class="mt-auto py-3">
                            <h5 class=" font-oswald-bold text-white">JOIN US AT</h5>
                            <!-- recommended nga 48char and below and count sa title gekan sa server para dli maguba ang css -->
                            <h2 class="font-weight-bold col-gold text-uppercase">DON CARLOS YEAR END CONCERT</h2>
                            <div class="d-flex flex-column flex-md-row ">
                                <p> <i class="far fa-clock"></i><span class="pl-1">5:00 PM - 12:00 AM</span>
                                </p>
                                <p class="ml-md-3"><i class="fas fa-map-marker-alt"></i><span class="pl-1">Don Carlos Gym</span>
                                </p>
                            </div>
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita
                                kasd
                            </p>
                            <h6 class="d-inline-block bg-gold px-4 py-2 text-white mt-3">31 Dec. 2020</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="my-4 text-center">
            <h2 class="font-oswald-bold">Events this March 2020</h2>
            <hr class="hr-center-thin ">
            <br>
            <p>Wla naku gi butngan ug date kay interconnected kau sa server unya basi naa naka library nga gamit para sa date sir</p>
        </div>
        <h2 class="text-center font-oswald-bold ">Upcoming Events</h2>
        <hr class="hr-center-thin ">
        <div class="row my-4">
            <div class="col-12 col-md-6 pt-3 ">
                <div class="card shadow-sm border-0 ">
                    <a href=" " class="col-darkGrey home-link-setting ">
                        <div class="position-relative ">
                            <img class="card-img " src="assets/images/band.jpg " style="max-height: 350px; " alt="Announcement Images ">
                            <h5 class="event-overlay p-3 m-0 bg-gold col-dirtyWhite font-weight-bold text-center ">31 <br> Dec.2020</h5>
                        </div>
                        <div class="m-3 ">
                            <h5 class="card-title font-weight-bold m-0 ">Don Carlos Year end Concert</h5>
                            <div class="d-flex flex-column flex-md-row ">
                                <small><i class="far fa-clock "></i><span class="event-date pl-1 ">5:00 PM - 12:00 AM</span>
                                </small>
                                <small class="ml-md-3 "><i class="fas fa-map-marker-alt "></i><span class="news-date pl-1 ">Don Carlos Gym</span>
                                </small>
                            </div>
                            <p class="card-text mt-2 ">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,</p>
                        </div>
                    </a>

                </div>
            </div>
            <div class="col-12 col-md-6 pt-3 ">
                <div class="card shadow-sm border-0 ">
                    <a href=" " class="col-darkGrey home-link-setting ">
                        <div class="position-relative ">
                            <img class="card-img " src="assets/images/band.jpg " style="max-height: 350px; " alt="Announcement Images ">
                            <h5 class="event-overlay p-3 m-0 bg-gold col-dirtyWhite font-weight-bold text-center ">31 <br> Dec.2020</h5>
                        </div>
                        <div class="m-3 ">
                            <h5 class="card-title font-weight-bold m-0 ">Don Carlos Year end Concert</h5>
                            <div class="d-flex flex-column flex-md-row ">
                                <small><i class="far fa-clock "></i><span class="event-date pl-1 ">5:00 PM - 12:00 AM</span>
                                </small>
                                <small class="ml-md-3 "><i class="fas fa-map-marker-alt "></i><span class="news-date pl-1 ">Don Carlos Gym</span>
                                </small>
                            </div>
                            <p class="card-text mt-2 ">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat,</p>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
