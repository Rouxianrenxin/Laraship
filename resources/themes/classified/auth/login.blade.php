@extends('layouts.auth')

@section('title',trans('corals-classified-master::auth.login'))

@section('css')
    {!! \Theme::css('css/AdminLTE-bootstrap-social.min.css') !!}

    <style type="text/css">
        .login-left {
            border-right: 4px solid #ddd;
        }

        @media (max-width: 470px) {
            .login-left {
                border-right: none;
            }
        }

        .or-separator {
            text-align: center;
            margin: 10px 0;
            text-transform: uppercase;
        }

        .or-separator:after, .or-separator:before {
            content: ' -- ';
        }
    </style>
@endsection

@section('hero_area')
    @include('partials.page_header',['content'=> '<h2 class="product-title">'.trans('corals-classified-master::auth.login').'</h2>'])
@endsection

@section('content')
    <section class="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xs-12">
                    <div class="login-form login-area">
                        <h3>
                            @lang('corals-classified-master::auth.sign_in_start_session')
                        </h3>
                        <div class="p-2">
                            @php \Actions::do_action('pre_login_form') @endphp
                        </div>
                        <div class="row">
                            <div class="col-md-6 login-left">
                                <form role="form" method="POST" action="{{ route('login') }}" class="login-form"
                                      id="login-form">
                                    {{ csrf_field() }}
                                    <div class="form-group text-center">
                                        @if(session('confirmation_user_id'))
                                            <a href="{{ route('auth.resend_confirmation') }}">@lang('User::labels.confirmation.resend_email')</a>
                                        @endif
                                    </div>
                                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <div class="input-icon">
                                            <i class="lni-user"></i>
                                            <input type="text" id="email" class="form-control" name="email"
                                                   placeholder="@lang('User::attributes.user.email')"
                                                   value="{{ old('email') }}" autofocus>
                                        </div>
                                        @if ($errors->has('email'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                        <div class="input-icon">
                                            <i class="lni-lock"></i>
                                            <input type="password" name="password" class="form-control" id="password"
                                                   placeholder="@lang('User::attributes.user.password')">
                                        </div>
                                        @if ($errors->has('password'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3 has-feedback">
                                        <div class="checkbox">
                                            <input type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}/>
                                            @lang('corals-classified-master::auth.remember_me')
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-common log-btn btn-block">@lang('corals-classified-master::auth.login')</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="login-form">
                                    <a href="{{ route('register') }}"
                                       class="btn bg-olive btn-social btn-block">
                                        <span class="fa fa-user-o"></span>
                                        @lang('corals-classified-master::auth.register_new_account')
                                    </a>
                                    <a href="{{ route('password.request') }}"
                                       class="btn bg-orange btn-social btn-block">
                                        <span class="fa fa-question"></span>
                                        @lang('corals-classified-master::auth.forget_password')
                                    </a>
                                    <div class="or-separator">@lang('Corals::labels.or')</div>
                                    <div class="socials-buttons">
                                        @if(config('services.facebook.client_id'))
                                            <a class="btn btn-block btn-social btn-facebook"
                                               href="{{ route('auth.social', 'facebook') }}">
                                                <span class="fa fa-facebook"></span> @lang('corals-classified-master::auth.sign_in_facebook')
                                            </a>
                                        @endif
                                        @if(config('services.twitter.client_id'))
                                            <a class="btn btn-block btn-social btn-twitter"
                                               href="{{ route('auth.social', 'twitter') }}">
                                                <span class="fa fa-twitter"></span> @lang('corals-classified-master::auth.sign_in_twitter')
                                            </a>
                                        @endif
                                        @if(config('services.google.client_id'))
                                            <a class="btn btn-block btn-social btn-google"
                                               href="{{ route('auth.social', 'google') }}">
                                                <span class="fa fa-google"></span> @lang('corals-classified-master::auth.sign_in_google')
                                            </a>
                                        @endif
                                        @if(config('services.github.client_id'))
                                            <a class="btn btn-block btn-social btn-github"
                                               href="{{ route('auth.social', 'github') }}">
                                                <span class="fa fa-github"></span> @lang('corals-classified-master::auth.sign_in_github')
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            if (!$(".socials-buttons").children().length > 0) {
                $(".or-separator").remove();
            }
        });
    </script>
@endsection