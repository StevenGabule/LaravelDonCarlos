@extends('layouts.app')
@section('content')
    <!-- inlineng the background image so it can be dynamicaly change!!!! -->
    <!-- recommended background dimension 1920 x 1280 -->
    <div class="trending-bg-banner position-relative" style="background-image: url('../assets/images/cabadiangan-large.jpg');">
        <div class="trending-bg-banner-overlay h-100 ">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-3">
                        <h2 class="d-inline-block px-4 py-2 bg-gold font-oswald-bold text-white text-uppercase">cabadiangan falls</h2>
                        <!-- recommended nga 48char and below and count sa title gekan sa server para dli maguba ang css -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="mt-4">
            <h2 class="font-oswald-bold"> Cabadiagan Falls </h2>
            <p><i class="fas fa-map-marker-alt"></i><span class="pl-3 font-weight-bold">Brgy. Sinanguyan, Don Carlos, Bukidnoon</span></p>
            <span class="whitespace-prewrap">Curabitur feugiat justo at lectus posuere condimentum a sed lacus. Nunc porttitor quis nisl ut vestibulum. Aenean enim mi, vulputate non feugiat et, bibendum at est. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla facilisi. Curabitur rutrum porta mauris, tincidunt commodo nisi rhoncus ac. Integer consequat diam est. In bibendum accumsan justo, ut iaculis eros. Phasellus enim purus, egestas in nisi vitae, ultricies porta nunc. Proin dignissim dapibus nunc eu vulputate. Morbi sapien sapien, scelerisque sit amet semper vel, ullamcorper et leo. Donec non lobortis nisi, sit amet fringilla sapien. Duis tincidunt erat tellus, vitae posuere dolor fringilla sed. In sed dui faucibus, auctor nisi non, tempus nulla. Aliquam a metus lobortis massa egestas venenatis at id tortor.

                    Donec sagittis venenatis dolor, ut mattis erat cursus at. Donec feugiat, sapien ac tristique pretium, est dolor semper arcu, sit amet fermentum nulla eros et mauris. Duis nunc mi, porttitor ut lobortis sit amet, congue vel lorem. Aenean id pellentesque nisi, et rutrum lacus. Pellentesque laoreet, arcu vitae bibendum dapibus, libero sapien ultrices nisi, fermentum euismod mi tellus ac nisi. Curabitur tincidunt, ipsum eu congue dignissim, dui nibh mattis magna, vel elementum libero magna quis lacus. Nulla sit amet varius dolor, ut sagittis augue. Duis rutrum, dui ut ultricies tincidunt, ligula ligula pharetra ligula, et placerat enim justo a quam. Pellentesque quis hendrerit nisl. Donec accumsan ligula sed mauris sodales lacinia.

                    Phasellus at justo iaculis, luctus tellus non, rutrum diam. In blandit ex nulla, imperdiet sodales nisl dictum suscipit. Nullam auctor lorem enim, sed ultrices nunc finibus ac. Sed fringilla magna a turpis gravida, id varius neque vulputate. Quisque eget nulla nec velit venenatis pulvinar. Phasellus urna lacus, semper nec magna volutpat, laoreet luctus mauris. Suspendisse aliquam orci sit amet mattis vulputate. Suspendisse potenti. Cras ut leo pharetra, pharetra turpis feugiat, pharetra turpis. Praesent dictum est ut massa auctor, ac convallis felis dictum. Vivamus rutrum sollicitudin augue sed dapibus. Pellentesque finibus tellus eget mauris molestie, eget ullamcorper enim rhoncus. Sed fringilla sodales tincidunt. Morbi ac viverra enim.

                    Donec eu tincidunt mi, non porttitor nunc. Mauris pellentesque erat vitae nunc venenatis, ac consectetur augue ultrices. Phasellus in hendrerit libero. Suspendisse sollicitudin arcu eu mauris rhoncus, ac laoreet ex lobortis. Nullam convallis, nisl vitae molestie pharetra, tortor lacus imperdiet felis, sit amet vestibulum augue orci sed velit. Nunc venenatis eros sed neque ultricies semper. Morbi facilisis hendrerit rutrum. Vestibulum eget quam augue. Aliquam laoreet mattis purus, vitae commodo augue ultrices at. Nunc sed odio pellentesque, consectetur purus sit amet, varius mi.

                    Mauris auctor leo mi, in feugiat neque pretium ut. Integer quis dolor in ante tempus malesuada. Cras elit nisl, vestibulum eu ultrices quis, sodales sed orci. Donec maximus nibh leo, et vehicula sapien maximus sed. Quisque tempus, ex at egestas hendrerit, ex ante malesuada dolor, vitae consectetur tellus dui sit amet ligula. Integer tincidunt bibendum feugiat. Duis condimentum porttitor nunc, ultrices aliquet libero. Integer sit amet sem erat. Maecenas cursus justo vel lectus commodo, at tristique lectus mattis. Quisque id dolor id lacus tristique interdum. Donec quis elementum justo. Fusce venenatis facilisis nulla sed posuere.
                </span>
            <h4 class="font-oswald-bold mt-4">Discover Cabadiagan Falls</h4>
            <div class="row">
                <div class="col-6 col-lg-4 pt-4">
                    <img src="assets/images/cabadiangan.jpg" class="img-fluid w-100" alt="details-images">
                </div>
                <div class="col-6 col-lg-4 pt-4">
                    <img src="assets/images/cabadiangan.jpg" class="img-fluid w-100" alt="details-images">
                </div>
                <div class="col-6 col-lg-4 pt-4">
                    <img src="assets/images/cabadiangan.jpg" class="img-fluid w-100" alt="details-images">
                </div>
                <div class="col-6 col-lg-4 pt-4">
                    <img src="assets/images/cabadiangan.jpg" class="img-fluid w-100" alt="details-images">
                </div>
                <div class="col-6 col-lg-4 pt-4 ">
                    <img src="assets/images/cabadiangan.jpg" class="img-fluid w-100" alt="details-images">
                </div>
                <div class="col-6 col-lg-4 pt-4 ">
                    <img src="assets/images/cabadiangan.jpg" class="img-fluid w-100" alt="details-images">
                </div>
            </div>
        </div>
        <br>
        <h5 class="font-oswald-bold mt-4">Related Posts</h5>
        <hr class="hr-thin">
        <div class="row mb-4 mt-2">
            <div class="col-12 col-sm-6 col-lg-4 pt-3">
                <div class="card bg-light shadow-sm border-0">
                    <div>
                        <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                        <img class="card-img max-height-250" src="assets/images/squash.jpg" alt="Announcement Images">
                    </div>
                    <div class="card-body">
                        <h4 class="font-oswald-bold text-uppercase">Squash Mountain</h4>
                        <p class="col-gold">Brgy. Sinanguyan, Don Carlos, Bukidnoon</p>
                        <p class="card-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita
                            kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor</p>
                        <button class="btn btn-outline-gold px-4 py-1 rounded-0"><small>Visit Spot</small></button>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 pt-3">
                <div class="card bg-light shadow-sm border-0">
                    <div>
                        <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                        <img class="card-img max-height-250" src="assets/images/linking.jpg" alt="Announcement Images">
                    </div>
                    <div class="card-body">
                        <h4 class="font-oswald-bold text-uppercase">Linking cave</h4>
                        <p class="col-gold">Brgy. San Antonio East, Don Carlos, Bukid...</p>
                        <p class="card-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita
                            kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor</p>
                        <button class="btn btn-outline-gold px-4 py-1 rounded-0"><small>Visit Spot</small></button>
                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 pt-3">
                <div class="card bg-light shadow-sm border-0">
                    <div>
                        <!-- recomendedd landscape image to prevent bluring in when changing screen size -->
                        <img class="card-img max-height-250" src="assets/images/cabadiangan.jpg" alt="Announcement Images">
                    </div>
                    <div class="card-body">
                        <h4 class="font-oswald-bold text-uppercase">cabadiangan falls</h4>
                        <p class="col-gold">Brgy. Cabadiangan, Don Carlos, Bukidnoon</p>
                        <p class="card-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita
                            kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor</p>
                        <button class="btn btn-outline-gold px-4 py-1 rounded-0"><small>Visit Spot</small></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
