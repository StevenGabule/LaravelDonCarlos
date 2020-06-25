<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Oswald:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/index.js') }}" defer></script>
    @yield('custom')

</head>
<body>
<!-- the first header that is transparent -->
<header>
    <div id="app">
        <div class="container pt-2 d-flex">
            <h5 class="font-lato-bold mr-4 col-gold">GOV.PH</h5>
            <div class="d-none d-md-block">
                <div class="d-flex">
                    <p class="mr-4 mb-0"><i class="fas fa-phone-alt col-green"></i>&nbsp;&nbsp;(088) 828 4817</p>
                    <p class="mr-4 mb-0"><i class="fas fa-map-marker-alt col-green"></i>&nbsp;&nbsp;Sample St. Don
                        Carlos
                        City</p>
                </div>
            </div>
            <div class="ml-auto d-flex">
                <div>
                    <a href="http://"><img src="{{ asset('assets/icons/fb.svg') }}" alt=""></a>
                    <a href="http://"><img src="{{ asset('assets/icons/tw.svg') }}" alt=""></a>
                    <a href="http://"><img src="{{ asset('assets/icons/insta.svg') }}" alt=""></a>
                </div>
            </div>
        </div>
</header>
<!-- nav links -->
<div class="nav-head bg-navTransparent">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <a class="navbar-brand" href="{{ route('index') }}">
            <div class="d-flex">
                <img src="{{ asset('assets/icons/logo.svg') }}" alt="" class="img-fluid"> &nbsp;&nbsp;
                <p class="font-oswald-bold h4 my-auto">Don Carlos</p>
            </div>
        </a>
        <!-- <a class="navbar-brand" href="#"><img src="assets/icons/logo.svg" alt="">&nbsp;&nbsp;<span class="font-oswald wght-bold h2 pt-5">Don Carlos</span></a> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <!-- <i class="fas fa-bars"></i> -->
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('services') }}">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('transparency') }}">Transparency</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('news') }}">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tourism') }}">Tourism</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/events">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contacts">Contact Us</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                           class="nav-link" href="{{ route('logout') }}">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
</div>
<!-- carousel banner for home -->

<main class="py-4">
    @yield('content')
</main>
<!-- banner for contact us -->
<article class="bg-green cnct-banner">
    <div class="container py-3">
        <div class="row">
            <div class="col-12 col-md-8 col-dirtyWhite mb-3 font-weight-bold">
                <span>If you have any concern... We are available</span>
            </div>
            <div class="col-12 col-md-4 ">
                <span class="ml-auto">
                    <button class="btn btn-outline-banner btn-large w-100 font-weight-bold">
                        Contact Us
                    </button>
                </span>
            </div>
        </div>
    </div>
</article>

<footer>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-md-3 pb-2">
                <div>
                    <h3 class="font-oswald-med">About Don Carlos</h3>
                    <hr class="hr-thick"></hr>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vestibulum tempus auctor. Morbi
                    porta tristique laoreet. Aenean cursus ex arcu, ac pulvinar nibh pulvinar quis. Nunc erat est,
                    elementum nec erat in, iaculis semper justo.
                </p>
            </div>
            <div class="col-12 col-md-3 pb-2">
                <div>
                    <h3 class="font-oswald-med">Contact Details</h3>
                    <hr class="hr-thick"></hr>
                </div>
                <p><i class="fas fa-phone-alt"></i>&nbsp;&nbsp;(088) 828 4817</p>
                <p><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;Sample St. Don Carlos City</p>
                <p><i class="fas fa-envelope"></i>&nbsp;&nbsp;Samplemail@mail.com</p>
            </div>
            <div class="col-12 col-md-3 pb-2">
                <div>
                    <h3 class="font-oswald-med">Useful Links</h3>
                    <hr class="hr-thick"></hr>
                </div>
                <p>
                    <i class="fas fa-square"></i>&nbsp;&nbsp;
                    <a href="http://">Home</a>
                </p>
                <p>
                    <i class="fas fa-square"></i>&nbsp;&nbsp;
                    <a href="http://">About Don Carlos</a>
                </p>
                <p>
                    <i class="fas fa-square"></i>&nbsp;&nbsp;
                    <a href="http://">Transparency</a>
                </p>
                <p>
                    <i class="fas fa-square"></i>&nbsp;&nbsp;
                    <a href="http://">Tourism</a>
                </p>
                <p>
                    <i class="fas fa-square"></i>&nbsp;&nbsp;
                    <a href="http://">Events</a>
                </p>
            </div>
            <div class="col-12 col-md-3 pb-2">
                <div>
                    <h3 class="font-oswald-med">Services</h3>
                    <hr class="hr-thick"></hr>
                </div>
                <p>
                    <i class="fas fa-square"></i>&nbsp;&nbsp;
                    <a href="http://">Civil Registry</a>
                </p>
                <p>
                    <i class="fas fa-square"></i>&nbsp;&nbsp;
                    <a href="http://">Social Services</a>
                </p>
            </div>
        </div>
    </div>
</footer>
</div>

@stack('scripts')
</body>
</html>


