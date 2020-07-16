@extends('layouts.app')
@section('content')
    <div class="about-bg-banner position-relative"
         style="background-image: url('{{ asset('../assets/images/munhall2.jpg') }}');margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100 ">
            <div class="container col-dirtyWhite h-100">
                <div class="d-flex h-100">
                    <div class="mt-auto py-3">
                        <h2 class="d-inline-block py-4 font-weight-bold text-white">ABOUT US</h2>
                        <!-- recommended nga 48char and below and count sa title gekan sa server para dli maguba ang css -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumbs -->
    <div class="container">
        <nav aria-label="breadcrumb" class="about-breadcrumb h6 my-4">
            <a href="{{ route('index') }}">Home</a>
            <span class="px-2">&gt;</span>
            <span>Know Don Carlos</span>
        </nav>
        <hr class="hr-thin"/>

        <div class="row my-4">
            <div class="col-12 col-md-9 pr-lg-5 pt-3">
                <div class="card mb-3 border-0 shadow-sm font-weight-bold">
                    <div class="card-body">
                        <a href="{{ route('page.show', ['slug' => $content->slug]) }}" class="text-dark text-hover">History
                            of Don Carlos, Bukidnon</a>
                    </div>
                </div>

                <div class="card mb-3 border-0 shadow-sm font-weight-bold">
                    <div class="card-body">
                        <a href="{{ route('about.baranggay') }}" class="text-dark text-hover">Baranggay</a>
                    </div>
                </div>

                <div class="card mb-3 border-0 shadow-sm font-weight-bold">
                    <div class="card-body">
                        <a href="{{ route('departments') }}" class="text-dark text-hover">Department And Offices</a>
                    </div>
                </div>

                <div class="card mb-3 border-0 shadow-sm font-weight-bold">
                    <div class="card-body">
                        <a href="{{ route('page.show', ['slug' => $content1->slug]) }}" class="text-dark text-hover">Mission
                            And Vision</a>
                    </div>
                </div>

                <div class="card mb-3 border-0 shadow-sm font-weight-bold">
                    <div class="card-body">
                        <a href="{{ route('mandate') }}" class="text-dark text-hover">Mandate</a>
                    </div>
                </div>

                <div class="card mb-3 border-0 shadow-sm font-weight-bold">
                    <div class="card-body">
                        <a href="{{ route('awards') }}" class="text-dark text-hover">Awards</a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="d-none d-md-block">
                    <h4 class="font-oswald-bold mt-5">Latest Articles</h4>
                    <hr class="hr-thin">
                </div>

                <div class="row d-none d-md-block">
                    @include('_shared._articles')
                </div>
            </div>

        </div>
    </div>

@endsection
