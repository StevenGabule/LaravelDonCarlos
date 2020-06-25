@extends('layouts.app')
@section('content')
    @php
        $month = ["", 'Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sept','Oct', 'Nov', 'Dec']
    @endphp
    <div class="trending-bg-banner-tourism position-relative"
         style="background-image: url('{{ asset('/backend/uploads/activities/'.$upcoming->avatar) }}'); margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100">
            <div class="container col-dirtyWhite h-100">
                <div class="col-12 col-md-6 h-100">
                    <div class="d-flex h-100">
                        <div class="mt-auto py-3">
                            <h5 class=" font-oswald-bold text-white">JOIN US AT</h5>
                            <!-- recommended nga 48char and below and count sa title gekan sa server para dli maguba ang css -->
                            <h2 class="font-weight-bold col-gold text-uppercase">
                                {{ (int)strlen($upcoming->title) <= 48 ? $upcoming->title : substr($upcoming->title, 0, 48) . '...' }}
                            </h2>
                            <div class="d-flex flex-column flex-md-row">
                                <p><i class="far fa-clock"></i><span
                                        class="pl-1">{{ $upcoming->make_date() }}</span>
                                </p>
                                <p class="ml-md-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span class="pl-1">{{ $upcoming->address }}</span>
                                </p>
                            </div>
                            <p>{{ $upcoming->short_description }}</p>
                            <h6 class="d-inline-block bg-gold px-4 py-2 text-white mt-3">
                                {{ $upcoming->display_date('day') }} {{ $month[$upcoming->display_date('month')] }} {{ $upcoming->display_date('year') }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <h2 class="text-center font-oswald-bold pt-4">Upcoming Events</h2>
        <hr class="hr-center-thin">
        <div class="row my-4">
            @forelse($activities as $event)
            <div class="col-12 col-md-6 pt-3">
                <div class="card shadow-sm border-0">
                    <a href="{{ route('event.show', ['slug' => $event->slug]) }}" class="col-darkGrey home-link-setting">
                        <div class="position-relative">
                            <img class="card-img"
                                 src="{{ ($event->avatar !== null) ?
                                            asset('/backend/uploads/activities/' . $event->avatar)
                                            : asset('assets/icons/images.svg') }}"
                                 style="max-height: 350px;"
                                 alt="{{ $event->title }}">
                            <h5 class="event-overlay p-3 m-0 bg-gold col-dirtyWhite font-weight-bold text-center">
                                {{ $event->display_date('day') }} <br>
                                {{ $month[$event->display_date('month')] }}
                                {{ $event->display_date('year') }}
                            </h5>
                        </div>
                        <div class="m-3">
                            <h5 class="card-title font-weight-bold m-0">{{ $event->title }}</h5>
                            <div class="d-flex flex-column flex-md-row">
                                <small>
                                    <i class="far fa-clock"></i>
                                    <span class="event-date pl-1">{{ $event->make_date() }}</span>
                                </small>
                                <small class="ml-md-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span class="news-date pl-1">{{ $event->address }}</span>
                                </small>
                            </div>
                            <p class="card-text mt-2">
                                {{ strlen($event->short_description) <= 165 ? $event->short_description : substr($event->short_description, 0, 165) . '...' }}
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            @empty
                <p>Oops.. No upcoming event </p>
            @endforelse
        </div>
    </div>
@endsection