<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>{{ __('messages.app_name_josh') }} {{ __('messages.reset_password') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico')}}" />
    <!--page level css -->
    <link href="{{ asset('css/main.css')}}" rel="stylesheet">


    <link href="{{ asset('vendors/bootstrapvalidator/css/bootstrapValidator.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/auth.css')}}" rel="stylesheet">
    <!--end of page level css-->
</head>

<body id="sign-up" class="login_backimg">
    <div class="container mt-3rem">
        <div class="card ">
            <div class="row ">
                <div class="col-lg-6 col-12 card-align bg-white">
                    <div class="row">
                        <div class="col-12  signup-form">
                            <div class="card-header border-bottom-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="text-center">
                                            <span>{{ __('messages.app_name_josh') }}</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-md-12 signup-header-text">
                                        <span class="active fs-18">{{ __('messages.reset_password') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <form action="{{ route('password.update') }}" id="authentication" method="post"
                                            class="sign_validator">
                                            @csrf
                                            <input type="hidden" name="token" value="{{ $token }}">
                                            <div class="form-group">
                                                <label for="email"> {{ __('messages.email_address') }}</label>
                                                <input type="email"
                                                    class="form-control  form-control-lg @error('email') is-invalid @enderror"
                                                    id="email" name="email" placeholder="{{ __('messages.email_placeholder') }}"
                                                    value="{{ $email ?? old('email') }}" required />
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label for="password">{{ __('messages.password_label') }}</label>
                                                <input type="password"
                                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                    id="password" name="password" placeholder="{{ __('messages.password_label') }}" required />

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="password-confirm">{{ __('messages.confirm_password') }}</label>
                                                <input type="password"
                                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                                    id="password-confirm" name="password_confirmation"
                                                    placeholder="{{ __('messages.password_label') }}" required autocomplete="new-password" />

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <input type="submit" value="{{ __('messages.reset_password') }}"
                                                    class="btn btn-primary btn-block" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </div>
    <!-- begining of page level js -->
    <script src="{{ asset('js/app.js')}}" type="text/javascript"></script>

    <script src="{{ asset('vendors/bootstrapvalidator/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('vendors/jquery.backstretch/js/jquery.backstretch.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/pages/register.js')}}"></script>

</body>

</html>
