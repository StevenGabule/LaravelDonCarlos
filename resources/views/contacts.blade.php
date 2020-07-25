@extends('layouts.app')
@section('content')
    <!-- inlineng the background image so it can be dynamicaly change!!!! -->
    <!-- recommended background dimension 1920 x 1280 or landscape HD -->
    <div class="about-bg-banner position-relative"
         style="background: url('https://images.unsplash.com/photo-1534536281715-e28d76689b4d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80') no-repeat center center / cover;margin-top: -24px;">
        <div class="trending-bg-banner-overlay h-100">
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
            <a href="{{ route('index') }}">Home</a>
            <span class="px-2">&gt;</span>
            <span>Contact us</span>
        </nav>
        <hr class="hr-thin">
        <div class="row my-4">
            <div class="col-12 col-md-9 pr-lg-5 pt-3">
                <div class="shadow-sm px-4 py-5">
                    <form id="contactForm" method="get">
                        @csrf
                        <div class="form-group">
                            <label for="inputSubmit" class="font-weight-bold h5">
                                Subject
                            </label>
                            <input type="text"
                                   class="form-control border-bottom-gold"
                                   autofocus
                                   required
                                   value="subject value"
                                   name="subject"
                                   id="inputSubmit"
                                   aria-describedby="subjectHelp"
                                   placeholder="State your subject">
                        </div>

                        <div class="form-group">
                            <label for="inputName" class="font-weight-bold h5">Your Name</label>
                            <input type="text"
                                   class="form-control border-bottom-gold"
                                   name="name"
                                   value="John Paul L. Gabule"
                                   required
                                   id="inputName" aria-describedby="nameHelp" placeholder="Enter your name">
                        </div>

                        <div class="form-group mt-5">
                            <label for="inputEmailAddress" class="font-weight-bold h5">Email Address</label>
                            <input type="email" name="email" required
                                   class="form-control border-bottom-gold"
                                   value="lucasgabule@gmail.com"
                                   id="inputEmailAddress"
                                   placeholder="Enter your current email">
                        </div>

                        <div class="form-group mt-5">
                            <label for="inputMessage" class="font-weight-bold h5">Message</label>
                            <textarea name="message"
                                      id="inputMessage" cols="30"
                                      rows="10"
                                      required
                                      class="form-control border-bottom-gold"
                                      placeholder="Leave your message here...">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa, eos.</textarea>
                        </div>
                        <button type="submit" class="btn btn-warning" id="btnSubmit">
                          <i class="far fa-paper-plane mr-2"></i> Send</button>
                        <span id="form_result"></span>
                    </form>
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
@prepend('scripts')
    <script src="{{ asset('js/_custom.js') }}" defer></script>
@endprepend
