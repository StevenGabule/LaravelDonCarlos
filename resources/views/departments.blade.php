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
            <a href="{{ route('about') }}">Know Don Carlos</a>
            <span class="px-2">&gt;</span>
            <span class="">Departments</span>

        </nav>
        <hr class="hr-thin"/>

        <div class="row my-4">
            <div class="col-12 col-md-9 pr-lg-5 pt-3">

                @forelse($departments as $department)
                    <a href="{{ route('departments.list', ['id' => $department->id, 'slug' => $department->slug]) }}" class="text-dark text-hover shadow-lg">
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="font-weight-bold">{{ $department->name }}</h6>
                                <p class="text-muted small">{{ $department->description  }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p>Oop... No departments</p>
                @endforelse

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
