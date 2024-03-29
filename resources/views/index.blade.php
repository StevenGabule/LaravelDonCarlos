@extends('layouts.app')
@section('custom')
  <style>
    /* Carousel base class */
    .carousel {
      margin-top: -24px;
    }

    /* Declare heights because of positioning of img element */
    .carousel-item {
      height: 32rem;
    }

    .carousel-item > img {
      position: absolute;
      top: 0;
      left: 0;
      min-width: 100%;
      height: 32rem;
    }

    .carousel-inner {
      position: relative;
    }

    /* Since positioning the image, we need to help out the caption */
    .carousel-caption {
      bottom: 0rem;
      z-index: 10;
    }
  </style>
@stop
@section('content')

  <div id="myCarousel" class="carousel slide carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      @if(!is_null($newHeadLine))
        <div class="carousel-item active"
             style="background: url('{{ $newHeadLine->display_image() }}') no-repeat center center / cover">
          <div class="container">
            <div class="carousel-caption mb-5" style="background-color: rgba(0,0,0,0.4)">
              <h3><a class="text-white"
                     href="{{ route('news.detail', ['slug' => $newHeadLine->slug]) }}">{{ $newHeadLine->title }}</a>
              </h3>
              <p class="lead">{{ $newHeadLine->short_description }}</p>
            </div>
          </div>
        </div><!-- news update -->
      @endif
      @if(!is_null($eventHeadLine))
        <div class="carousel-item"
             style="background: url('{{ $eventHeadLine->display_image() }}') no-repeat center center / cover;">
          <div class="container">
            <div class="carousel-caption  mb-5" style="background-color: rgba(0,0,0,0.4)">
              <h3><a class="text-white"
                     href="{{ route('event.show', ['slug' => $eventHeadLine->slug]) }}">{{ $eventHeadLine->title }}</a>
              </h3>
              <p class="lead">{{$eventHeadLine->short_description}}</p>
            </div>
          </div>
        </div><!-- events -->
      @endif

      @if(!is_null($placeHeadLine))
        <div class="carousel-item"
             style="background: url('{{ $placeHeadLine->display_image() }}') no-repeat center center / cover">

          <div class="container">
            <div class="carousel-caption mb-5" style="background-color: rgba(0,0,0,0.4)">
              <h3>
                <a class="text-white" href="/place/{{$placeHeadLine->slug}}">{{ $placeHeadLine->name }}</a>
              </h3>
              <p class="lead">{{ $placeHeadLine->short_description }}</p>
            </div>
          </div>
        </div><!-- tourism -->
      @endif
    </div>

    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>

    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div><!-- end of carousel -->

  <!-- main content for home  -->
  <main class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-9">
          <h2 class="font-oswald-bold">Plans and Programs</h2>
          <hr class="hr-thin">
          <div class="row no-gutters w-100 text-center">
            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl p-2">
              <a href="{{ route('page.show', ['slug' => $infrastructure->slug]) }}"
                 class="btn btn-home-programs py-3 px-0 shadow-sm w-100">
                <i class="fas fa-university fa-2x"></i><br>
                <span class="font-weight-bold">Infrastructure</span>
              </a>
            </div>
            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl p-2">
              <a href="{{ route('page.show', ['slug' => $agriculture->slug]) }}"
                 class="btn btn-home-programs py-3 shadow-sm w-100"><i
                  class="fas fa-tractor fa-2x"></i><br><span
                  class="font-weight-bold">Agriculture</span>
              </a>
            </div>

            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl p-2">
              <a href="{{ route('page.show', ['slug' => $healthcare->slug]) }}"
                 class="btn btn-home-programs py-3 shadow-sm w-100"><i
                  class="fas fa-heartbeat fa-2x"></i><br><span
                  class="font-weight-bold">Healthcare</span></a>
            </div>

            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl p-2">
              <a href="{{ route('page.show', ['slug' => $education->slug]) }}"
                 class="btn btn-home-programs py-3 shadow-sm w-100"><i
                  class="fas fa-graduation-cap fa-2x"></i><br><span
                  class="font-weight-bold">Education</span></a>
            </div>

            <div class="col-6 col-sm-4 col-md-4 col-lg-3 col-xl p-2">
              <a href="{{ route('page.show', ['slug' => $tourism->slug]) }}"
                 class="btn btn-home-programs py-3 shadow-sm w-100"><i
                  class="fas fa-plane fa-2x"></i><br><span
                  class="font-weight-bold">Tourism</span>
              </a>
            </div>
          </div>

          <!-- the first page content section -->
          <div class="d-flex flex-column flex-md-row my-5 prog-content-container">
            <!-- ge background nako ang image para dili mo stretch -->
            <div class="prog-cont-image1"
                 style="background-image: url('{{ $contents[0]->display_image() }}');"></div>
            <!-- <img src="assets/images/airport.jpg" alt=""> -->
            <div class="text-center mt-5 mt-md-0 mx-md-4">
              <h3 class="font-weight-bold">{{ $contents[0]->title }}</h3>
              <hr class="hr-center-thin">
              <p class="my-4">{{ $contents[0]->short_description }}</p>
              <a href="{{ route('page.show', ['slug' => $contents[0]->slug]) }}"
                 class="btn btn-outline-gold px-5">
                Learn More
              </a>
            </div>
          </div>
          <!-- Meet the woman to care section -->
          <div class="bg-light px-3 py-5 d-flex flex-column flex-md-row">
            <div class="text-center">
              <h3 class="font-weight-bold">{{ $contents[1]->title }}</h3>
              <hr class="hr-center-thin">
              <p class="my-4">{{ $contents[1]->short_description  }}</p>
              <a href="{{ route('page.show', ['slug' => $contents[1]->slug]) }}"
                 class="btn btn-outline-gold px-5">
                Learn More
              </a>
            </div>
            <div class="ml-md-3 mt-3 mt-md-0">
              <!-- inline image so that it can be change -->
              <div class="prog-cont-image2"
                   style="background-image: url('{{ $contents[1]->display_image() }}');"></div>
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
            @include('layouts.hotline')
          </div>
          <div class="mt-5">
            <h2 class="font-oswald-bold">Announcement</h2>
            <hr class="hr-thin">
            <div class="row">
              @forelse($newsImportant as $important)
                <div class="col-12 col-sm-6 col-lg-12 pt-3">
                  <div class="card bg-light shadow-sm border-0">
                    <div>
                      <!-- recommended landscape image to prevent blurring in when changing screen size -->
                      <img class="card-img max-height-150"
                           src="{{  $important->display_image() }}"
                           alt="Announcement Images">
                      <div class="bg-deepRed px-4 rounded-left text-white important-overlay">
                        IMPORTANT
                      </div>
                    </div>
                    <div class="card-body">
                      <h6 class="card-title font-weight-bold">
                        {{ $important->created }}
                        : {{ $important->display_data($important->title, 50) }}</h6>
                      <p class="card-text">
                        {{ $important->display_data($important->short_description, 140) }}
                      </p>
                      <a href="{{ route('news.detail', ['slug' => $important->slug]) }}"
                         class="btn btn-outline-gold px-4 py-1">
                        <small>More Info</small>
                      </a>
                    </div>

                  </div>
                </div><!-- end of col 12 -->
              @empty
                <p class="pl-3">No announcement's today</p>
              @endforelse
            </div><!-- end of row -->
          </div><!-- end of announcement  -->
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
            @if(!is_null($latestNews))
            <p class="my-4">{{ $latestNews->short_description }}</p>
            <a href="{{ route('news.detail', ['slug' => $latestNews->slug]) }}"
               class="btn btn-outline-gold px-4 py-1">
              <small>More Info</small>
            </a>
              @endif
          </div>

          @foreach($news as $new)
            <div class="col-12 col-sm-6 col-lg-3 pt-3">
              <div class="card shadow-sm border-0 p-3">
                <img class="card-img"
                     src="{{ $new->display_image() }}"
                     style="max-height: 150px;object-fit: cover"
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
                  <a href="{{ route('news.detail', ['slug' => $new->slug]) }}"
                     class="btn btn-outline-gold px-4 py-1">
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
      <h2 class="text-center font-oswald-bold">Activities And Upcoming Events</h2>
      <hr class="hr-center-thin">
      <div class="row my-4">
        @php
          $month = ["", 'Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sept','Oct', 'Nov', 'Dec']
        @endphp
        <div class="col-12 col-md-6 pt-3">
          <div class="card shadow-sm border-0">
            <a href="{{ route('event.show', ['slug' => $latestActivity->slug]) }}"
               class="col-darkGrey home-link-setting">
              <div class="position-relative">
                <img class="card-img"
                     src="{{ $latestActivity->display_image() }}"
                     style="max-height: 350px;object-fit: cover;"
                     alt="Announcement Images">
                <h5 class="event-overlay p-3 m-0 bg-green-event col-dirtyWhite font-weight-bold text-center">
                  {{ $latestActivity->display_date('day') }}
                  <br>
                  {{ $month[$latestActivity->display_date('month')] }} {{ $latestActivity->display_date('year') }}
                </h5>
              </div>
              <div class="m-3">
                <h5 class="card-title font-weight-bold m-0 text-capitalize">{{ $latestActivity->title }}</h5>
                <div class="d-flex flex-column flex-md-row ">
                  <small>
                    <i class="far fa-clock"></i>
                    <span class="event-date pl-1">
                                            {{ date_format(date_create($latestActivity->opening_time), 'g:iA') }} -
                                            {{ date_format(date_create($latestActivity->closing_time), 'g:iA') }}
                                        </span>
                  </small>
                  <small class="ml-md-3">
                    <i class="fas fa-map-marker-alt"></i>
                    <span class="news-date pl-1 text-capitalize">
                                            {{ $latestActivity->display_address }}
                                        </span>
                  </small>
                </div>
                <p class="card-text mt-2">{{ $latestActivity->short_description }}</p>
              </div>
            </a>
          </div>
        </div>

        <div class="col-12 col-md-6 pt-3">
          <div class="d-flex flex-column">
            @if(!is_null($activities))
              @foreach($activities as $activity)
                <a href="{{ route('event.show', ['slug' => $activity->slug]) }}"
                   class="home-link-setting mb-3" title="{{ $activity->id }}">
                  <div class="d-flex flex-row event-list col-darkGrey">
                    <h5 class="font-weight-bold bg-green-event px-2 py-5 text-white text-center m-0">
                      {{ $activity->display_date('day') }}
                      <br>
                      {{ $month[$activity->display_date('month')] }} {{ $activity->display_date('year') }}
                    </h5>
                    <div class="p-2 border-top border-bottom">
                      <h5 class="font-weight-bold mb-1">{{ $activity->title }}</h5>
                      <div class="d-flex flex-column flex-md-row ">
                        <small>
                          <i class="far fa-clock"></i>
                          <span class="event-date pl-1">
                              {{ $activity->opening_time }} -
                              {{ $activity->closing_time }}
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
            @endif
          </div><!-- end of UPCOMING EVENTS -->
        </div>
      </div>
    </div>
  </main>
@endsection

@section('script')
  <script>
    $(document).ready(function () {
      $('.carousel').carousel({
        keyboard: true,
        touch: true
      })
    })
  </script>
@stop
