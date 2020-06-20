<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        Don Carlos Log In Area
    </title>
    <link rel="stylesheet" href="{{ asset('backend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('frontend/logo/favicon.png') }}"/>
    <style>
        .auth form .auth-form-btn {
            line-height: 1;
        }
    </style>
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
            <div class="row flex-grow">
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <div class="auth-form-transparent text-left p-3">
                        <div class="brand-logo">
                            <a href="{{ url('/') }}"><img src="{{ asset('frontend/logo/logo.svg') }}" alt="logo"></a>
                        </div>
                        <h4>Welcome back!</h4>
                        <h6 class="font-weight-light">Use You Credentials To Log In</h6>
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
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div><!-- password -->

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

                        </form>
                    </div>
                </div>
                <div class="col-lg-6 login-half-bg d-flex flex-row">
                    <p class="text-white font-weight-medium text-center flex-grow align-self-end">
                        Copyright &copy; DonCarlos <?= ((int)date('Y') === 2020) ? date('Y') : "2020-" . date('Y') ?>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
