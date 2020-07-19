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
            color: #28a745;
            border-color: #28a745;
        }

        .page-item.active span.page-link {
            background-color: #28a745 !important;
            color: #F5F5F5 !important;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            border-color: #28a745 !important;;
        }
    </style>
@stop
@section('content')

    <div class="trending-bg-banner position-relative"
         style="background: url('{{ asset('assets/images/photo-1528988719300-046ff7faf8cb.jfif') }}') no-repeat bottom center / cover;margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-5">
                        <h2 class="d-inline-block px-4 py-2 bg-green-event font-weight-bold text-white">NEWS  </h2>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <main class="container my-4">
        <div class="row">
            <div class="col-12 col-lg-9">
                <!-- latest publication div section -->
                <div class="my-4">
                    <h5 class="font-oswald-bold">Latest Publication</h5>
                    <hr class="hr-thin">
                    <div class="row">
                        @forelse($news as $new)
                            <div class="col-12 col-sm-6 col-lg-4 pt-3">
                                <div class="card shadow-sm border-0 bg-light p-3">
                                    <img class="card-img"
                                         src="{{ $new->avatar ? $new->avatar : asset('assets/icons/images.svg') }}"
                                         style="max-height: 150px;"
                                         alt="Announcement Images">
                                    <div class="d-flex flex-row">
                                        <small class="flex-fill">
                                            <i class="far fa-user-circle"></i>
                                            <span class="user pl-1">{{ $new->user->name }}</span>
                                        </small>
                                        <small>
                                            <i class="far fa-clock"></i>
                                            <span class="news-date pl-1">{{ $new->created_at->diffForHumans() }}</span>
                                        </small>
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="card-title font-weight-bold">
                                            <a href="{{ route('news.detail', ['slug' => $new->slug]) }}"
                                               class="text-dark">{{ $new->created }}
                                                : {{ $new->display_data($new->title, 50) }}</a>
                                        </h6>
                                        <p class="card-text">
                                            {{ $new->display_data($new->short_description, 140) }}
                                        </p>
                                        <a href="{{ route('news.detail', ['slug' => $new->slug]) }}"
                                           class="btn btn-outline-gold px-4 py-1">
                                            <small>More Info</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="ml-3">Oops.. No data found</p>
                        @endforelse

                    </div>
                    <br>
                    <br>
                    {{$news->links()}}
                </div>
            </div>
            <div class="col-12 col-lg-3 p-4">
                <form action="{{ route('news') }}" method="get">
                    <div class="input-group">
                        <input class="form-control py-2 border-right-0 border" type="text" value="{{ $_GET['q']??'' }}"
                               name="q"
                               id="example-search-input" placeholder="Search...">
                        <span class="input-group-append">
                        <div class="input-group-text bg-transparent"><i class="fa fa-search"></i></div>
                    </span>
                    </div>
                </form>
                <div class="mt-3">
                    <h5 class="font-oswald-bold">Archive</h5>
                    <hr class="hr-thin">
                    <div class="d-flex w-100 pl-3">
                        <a href="" class="flex-fill trend-arch-list">
                            <p>2020</p>
                        </a>
                    </div>
                </div>
                <div class="mt-3">
                    <h5 class="font-oswald-bold">Featured Post</h5>
                    <hr class="hr-thin">
                    <div class="row">
                        @include('_shared._articles')
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
