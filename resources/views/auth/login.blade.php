<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        Login - Don Carlos Official Site
    </title>
    <link rel="stylesheet" href="{{ asset('backend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/icons/logo.svg') }}"/>
    <style>
        .auth form .auth-form-btn {
            line-height: 1;
        }

        /* Auth */
        .auth .login-half-bg {
            background: url("{{ asset('frontend/images/auth/login-bg.jpg') }}") top center;
            background-size: cover;
            position: relative;
        }

        .layer {
            /*background-color: rgba(248, 247, 216, 0.7);*/
            background: #00C9FF;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #92FE9D, #00C9FF);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #92FE9D, #00C9FF); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            opacity: 0.5;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

    </style>
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
            <div class="row flex-grow">
                <div class="col-lg-6 d-flex align-items-center justify-content-center bg-white">
                    <div class="auth-form-transparent text-left p-3">
                        <div class="brand-logo text-center">
                            <a href="{{ url('/') }}"><img src="{{ asset('assets/icons/don-carlos.png') }}" alt="logo"></a>
                        </div>
                        <h5 class="text-center">Official Site Of Don Carlos, Bukidnon</h5>
                        <h6 class="font-weight-light text-center">Use You Credentials To Log In</h6>
                        <form method="POST" action="{{ route('login') }}" class="pt-3">
                            @csrf
                            <div class="form-group">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                      <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fa fa-user text-primary"></i>
                                      </span>
                                    </div>
                                    <input
                                        type="email"
                                        class="form-control form-control-lg border-left-0 @error('email') is-invalid @enderror"

                                        name="email"
                                        id="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Email">
                                </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div><!-- email -->

                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                                      <span class="input-group-text bg-transparent border-right-0">
                                        <i class="fa fa-lock text-primary"></i>
                                      </span>
                                    </div>
                                    <input type="password"
                                           class="form-control form-control-lg border-left-0  @error('password') is-invalid @enderror"
                                           name="password"
                                           id="password"
                                           required autocomplete="current-password"
                                           placeholder="Password">
                                </div>

                            </div><!-- password -->
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label ml-1" for="remember">
                                            {{ __('Keep me signed in') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="my-3">
                                <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                   type="submit">LOGIN</button>
                            </div>
                            @if (isset($errors) && $errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{  $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 login-half-bg d-flex flex-row">
                    <p class="text-white font-weight-medium text-center flex-grow align-self-end">
                        Copyright &copy; DonCarlos <?= ((int)date('Y') === 2020) ? date('Y') : "2020-" . date('Y') ?>.
                    </p>
                    <div class="layer"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
