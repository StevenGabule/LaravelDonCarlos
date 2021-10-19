@extends('layouts.app')
@section('custom')
  <style>
    .about-bg-banner {
      height: 450px;
    }
  </style>
@stop
@section('content')

  <div class="about-bg-banner position-relative"
       style="background-image: url('{{ $post->avatar !== null ? $post->avatar : asset('assets/images/fallback.jfif') }}');margin-top: -24px;">
    <div class="trending-bg-banner-overlay h-100">
      <div class="container col-dirtyWhite h-100">
        <div class="d-flex h-100">
          <div class="mt-auto py-3">
            <h2 class="d-inline-block py-4 font-weight-bold text-white">{{ $transparent->title }}<br><span
                class="col-gold">TRANSPARENCY</span>
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- breadcrumbs -->
  <div class="container">
    <!-- tinanban kay para sa ako mas dali og mas sayon -->
    <nav aria-label="breadcrumb" class="about-breadcrumb h6 my-4">
      <a href="{{ route('index') }}">Home</a>
      <span class="px-2">&gt;</span>
      <a href="{{ route('transparency') }}">Transparency</a>
      <span class="px-2">&gt;</span>
      <a href="/transparent/{{$transparent->slug}}" class="text-capitalize">{{ $transparent->title }}</a>
      <span class="px-2">&gt;</span>
      <span>{{ $post->title }}</span>
    </nav>

    <hr class="hr-thin">

    <div class="row my-4">
      <div class="col-12 col-md-3">
        <div class="d-flex flex-column">
          @foreach($transparencies as $transparency)
            <a href="/transparent/{{$transparency->slug}}"
               class="about-side-nav px-4 py-2 rounded shadow-sm w-100 text-decoration-none mt-3 {{ $transparency->slug == $slug1 ? 'active' : '' }}">
              <p class="mb-0">{{ $transparency->title }} <i
                  class="fas fa-arrow-right float-right pt-1"></i></p>
            </a>
          @endforeach
        </div>

        <div class="d-none d-md-block">
          <h4 class="font-oswald-bold mt-5">Latest Articles</h4>
          <hr class="hr-thin">
        </div>

        <div class="row d-none d-md-block">
          @include('_shared._articles')
        </div>

      </div>
      <div class="col-12 col-md-9">
        <div class="pl-lg-4 pt-3">
          <h4 class="font-oswald-bold">{{ $post->title }}</h4>
          <hr class="hr-thin">
          @forelse($post->transparency_post_files as $item)
            <p class="small border p-3">
              <a class="btn-link mb-3" href="{{ asset('storage/uploads/transparent_files/' . $item->transparent_file->filename) }}">
                {{ $item->transparent_file->name }}
              </a>
            </p>
          @empty
            <p class="small border p-3">
              There's no transparent file attach.
            </p>
          @endforelse

          {!! $post->description !!}

          <div class="mb-3 mt-3">
            <div class="w-100 d-block">
              <div><p class="mb-0 mt-3">Share with anyone:</p></div>
              <script>(function (d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s);
                  js.id = id;
                  js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
              <div class="fb-share-button"
                   data-href="/transparency/{{ $transparent->slug }}/article/{{$post->slug}}"
                   data-layout="button_count">
              </div>
            </div>
          </div><!-- sharing content -->
        </div>
      </div>
    </div>
  </div>

@endsection
