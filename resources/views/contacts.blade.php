@extends('layouts.app')
@section('content')
    <!-- inlineng the background image so it can be dynamicaly change!!!! -->
    <!-- recommended background dimension 1920 x 1280 or landscape HD -->
    <div class="about-bg-banner position-relative" style="background-image: url('{{ asset('../assets/images/calling.jpg') }}');margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100 ">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-3">
                        <h2 class="d-inline-block py-4 font-weight-bold text-white">Contact Us</h2>
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
            <a href="">Home</a>
            <span class="px-2">></span>
            <a href="">Contact us</a>
        </nav>
        <hr class="hr-thin">
        <div class="row my-4">
            <div class="col-12 col-md-9 pr-lg-5 pt-3">
                <div class="shadow-sm px-4 py-5">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="font-weight-bold h5 ">Your Name</label>
                            <input type="email" class="form-control border-bottom-gold" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Name">
                            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                        </div>
                        <div class="form-group mt-5">
                            <label for="exampleInputPassword1" class="font-weight-bold h5">Email Address</label>
                            <input type="password" class="form-control border-bottom-gold" id="exampleInputPassword1" placeholder="Email Address">
                        </div>
                        <div class="form-group mt-5">
                            <label for="exampleInputPassword1" class="font-weight-bold h5">Message</label>
                            <textarea name="" id="" cols="30" rows="10" class="form-control border-bottom-gold" id="exampleInputPassword1" placeholder="Message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-gold px-4 py-1 rounded-0 mt-4">Submit</button>
                    </form>
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
                                <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                                <img class="card-img max-height-150" src="assets/images/munhall2.jpg " alt="Announcement Images ">
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
                                <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                                <img class="card-img max-height-150" src="assets/images/munhall2.jpg " alt="Announcement Images ">
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
