@extends('layouts.auth')

@section('title',trans('corals-quantum-admin::labels.auth.login'))

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('login') }}" id="login-form" class="sign-in-form">
            {{ csrf_field() }}
            <div class="card">
                <div class="card-body">
                    <a href="{{ url('/') }}" class="brand text-center d-block m-b-20">
                        <img src="{{ \Settings::get('site_logo') }}"
                             alt="{{ \Settings::get('site_name') }}"
                             class="img-fluid" style="max-width: 200px;"
                        />
                    </a>
                    <h5 class="sign-in-heading text-center m-b-20">@lang('corals-quantum-admin::labels.auth.sign_in_start_session')</h5>
                    @php \Actions::do_action('pre_login_form') @endphp
                    <div class="form-group text-center">
                        @if(session('confirmation_user_id'))
                            <a href="{{ route('auth.resend_confirmation') }}">@lang('User::labels.confirmation.resend_email')</a>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                        <label for="email" class="sr-only">@lang('User::attributes.user.email')</label>
                        <input type="email" name="email" id="email" class="form-control"
                               placeholder="@lang('User::attributes.user.email')"
                               value="{{ old('email') }}" autofocus required="">
                        @if ($errors->has('email'))
                            <small class="form-control-feedback">{{ $errors->first('email') }}</small>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                        <label for="inputPassword" class="sr-only">@lang('User::attributes.user.password')</label>
                        <input type="password" name="password" id="password" class="form-control"
                               placeholder="@lang('User::attributes.user.password')"
                               value="{{ old('password') }}" required="">

                    </div>
                    <div class="checkbox m-b-10 m-t-20">
                        <div class="custom-control custom-checkbox checkbox-primary form-check">
                            <input type="checkbox"
                                   name="remember"
                                   {{ old('remember') ? 'checked' : '' }} class="custom-control-input"
                                   id="customRemember"/>
                            <label class="custom-control-label"
                                   for="customRemember">@lang('corals-quantum-admin::labels.auth.remember_me')</label>
                        </div>
                        <a href="{{ route('password.request') }}" id="to-recover"
                           class="float-right"> @lang('corals-quantum-admin::labels.auth.forget_password')</a>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 my-2 text-center">
                            <div class="social">
                                @if(config('services.facebook.client_id'))

                                    <a class="btn btn-facebook" data-toggle="tooltip"
                                       title="@lang('corals-quantum-admin::labels.auth.sign_in_facebook')"
                                       href="{{ route('auth.social', 'facebook') }}">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                @endif
                                @if(config('services.twitter.client_id'))
                                    <a class="btn btn-twitter" data-toggle="tooltip"
                                       href="{{ route('auth.social', 'twitter') }}"
                                       title="@lang('corals-quantum-admin::labels.auth.sign_in_twitter')">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                @endif
                                @if(config('services.google.client_id'))
                                    <a class="btn btn-googleplus" data-toggle="tooltip"
                                       href="{{ route('auth.social', 'google') }}"
                                       title="@lang('corals-quantum-admin::labels.auth.sign_in_google')">
                                        <i class="fa fa-google"></i>
                                    </a>
                                @endif
                                @if(config('services.github.client_id'))
                                    <a class="btn btn-github" data-toggle="tooltip"
                                       href="{{ route('auth.social', 'github') }}"
                                       title="@lang('corals-quantum-admin::labels.auth.sign_in_github')">
                                        <i class="fa fa-github"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-rounded btn-floating btn-block"
                            type="submit">@lang('corals-quantum-admin::labels.auth.login')</button>


                    <a class="btn btn-success btn-rounded btn-floating btn-block" href="{{ route('register') }}"> @lang('corals-quantum-admin::labels.auth.register_new_account')</a>

                </div>

            </div>
        </form>
    </div>
@endsection
