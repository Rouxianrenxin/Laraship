@extends('layouts.theme')
@section('title','Login')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/flags.authy.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.css"/>
    <style type="text/css">
        #terms {
            color: black;
        }

        #terms-anchor {
            text-transform: uppercase;
        }
    </style>
@endsection
@section('editable_content')
    @php $isLogin=$isLogin??true;@endphp
    <div class="main-register-holder">
        <div class="main-register fl-wrap">

            <div id="tabs-container">
                <ul class="tabs-menu">
                    <li class="@if($isLogin) current @endif"><a href="#tab-1">@lang('corals-directory-basic::auth.login')</a></li>
                    <li class="@if(!$isLogin) current @endif"><a href="#tab-2">@lang('corals-directory-basic::auth.register')</a></li>
                </ul>
                <div class="tab">
                    <div id="tab-1" class="tab-content" style="@if(!$isLogin) display: none; @endif">
                        <div class="custom-form">
                            <div class="p-2">
                                @php \Actions::do_action('pre_login_form') @endphp
                            </div>

                            <div class="soc-log fl-wrap">
                                <p>@lang('corals-directory-basic::auth.sign_in_start_session')</p>

                                @if(config('services.facebook.client_id'))
                                    <a class="btn btn-block btn-social btn-facebook"
                                       href="{{ route('auth.social', 'facebook') }}">
                                        <span class="fa fa-facebook"></span> @lang('corals-directory-basic::auth.sign_in_facebook')
                                    </a>
                                @endif
                                @if(config('services.twitter.client_id'))
                                    <a class="btn btn-block btn-social btn-twitter"
                                       href="{{ route('auth.social', 'twitter') }}">
                                        <span class="fa fa-twitter"></span> @lang('corals-directory-basic::auth.sign_in_twitter')
                                    </a>
                                @endif
                                @if(config('services.google.client_id'))
                                    <a class="btn btn-block btn-social btn-google"
                                       href="{{ route('auth.social', 'google') }}">
                                        <span class="fa fa-google"></span> @lang('corals-directory-basic::auth.sign_in_google')
                                    </a>
                                @endif
                                @if(config('services.github.client_id'))
                                    <a class="btn btn-block btn-social btn-github"
                                       href="{{ route('auth.social', 'github') }}">
                                        <span class="fa fa-github"></span> @lang('corals-admin::labels.auth.sign_in_github')
                                    </a>
                                @endif
                            </div>
                            <div class="log-separator fl-wrap"><span>@lang('corals-directory-basic::auth.or')</span>
                            </div>

                            <form method="post" action="{{ url('business/login') }}" id="login-form"
                                  class="login-form custom-form">

                                {{ csrf_field() }}
                                <div class="form-group text-center">
                                    @if(session('confirmation_user_id'))
                                        <a href="{{ route('auth.resend_confirmation') }}">@lang('User::labels.confirmation.resend_email')</a>
                                    @endif
                                </div>
                                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label>@lang('User::attributes.user.email')*</label>
                                    <label><i class="fa fa-envelope-o"></i> </label>

                                    <input id="email" name="email" type="text" value="{{ old('email') }}"
                                           placeholder="@lang('User::attributes.user.email')" autofocus>
                                    @if ($errors->has('email'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback  {{ $errors->has('email') ? ' has-error' : '' }}">

                                    <label>@lang('User::attributes.user.password')*</label>
                                    <label><i class="fa fa-lock"></i> </label>

                                    <input id="password" name="password" type="password" onClick="this.select()"
                                           value=""
                                           placeholder="@lang('User::attributes.user.password')">

                                    @if ($errors->has('password'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group mb-3 has-feedback">
                                    <div class="filter-tags">
                                        <input id="check-a" type="checkbox"
                                               name="check" {{ old('remember') ? 'checked' : '' }}>
                                        <label for="check-a">@lang('corals-directory-basic::auth.remember_me')</label>
                                    </div>
                                </div>
                                <button type="submit" class="log-submit-btn">
                                    <span>@lang('corals-directory-basic::auth.login')</span></button>
                                <div class="clearfix"></div>

                            </form>
                            <div class="lost_password">
                                <a href="{{ route('password.request') }}">@lang('corals-directory-basic::auth.forget_password')</a>
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-content" style="@if(!$isLogin) display: block;  @endif">
                        <div class="custom-form">
                            <form method="POST" action="{{ url('business/register') }}" class="ajax-form login-form">
                                <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label>@lang('User::attributes.user.name')</label>
                                    <label><i class="fa fa-user"></i> </label>

                                    <input name="name" type="text" value="">

                                    @if ($errors->has('name'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label>@lang('User::attributes.user.last_name')</label>
                                    <label><i class="fa fa-user"></i> </label>

                                    <input name="last_name" type="text" value="">

                                    @if ($errors->has('last_name'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label>@lang('User::attributes.user.email')</label>
                                    <label><i class="fa fa-envelope-o"></i> </label>

                                    <input name="email" type="text" onClick="this.select()"
                                           value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label>@lang('User::attributes.user.password')</label>
                                    <label><i class="fa fa-lock"></i> </label>

                                    <input name="password" type="password">
                                    @if ($errors->has('password'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label>@lang('User::attributes.user.password_confirmation')</label>
                                    <label><i class="fa fa-lock"></i> </label>

                                    <input name="password_confirmation" type="password">
                                    @if ($errors->has('password'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div id="country-div"
                                     class="form-group has-feedback {{ $errors->has('phone_country_code') ? ' has-error' : '' }}">
                                    <label for="authy-countries"
                                           class="control-label">@lang('User::attributes.user.phone_country_code')
                                        :</label>
                                    <label><i class="fa fa-flag"></i> </label>

                                    <select class="form-control" id="authy-countries"
                                            name="phone_country_code"></select>
                                    <span class="glyphicon glyphicon-flag form-control-feedback"></span>

                                    @if ($errors->has('phone_country_code'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('phone_country_code') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                    <label for="authy-cellphone"
                                           class="control-label">@lang('User::attributes.user.phone_number')
                                        :</label>
                                    <label><i class="fa fa-phone"></i> </label>

                                    <input class="form-control" id="authy-cellphone"
                                           placeholder="@lang('User::attributes.user.cell_phone_number')"
                                           type="text"
                                           value="{{ old('phone_number') }}"
                                           name="phone_number"/>
                                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>

                                    @if ($errors->has('phone_number'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group has-feedback {{ $errors->has('terms') ? ' has-error' : '' }}">
                                    <div class="filter-tags">
                                        <label>
                                            <input name="terms" value="1" type="checkbox"/>
                                            <strong>@lang('corals-directory-basic::auth.agree')
                                                <a href="#" data-toggle="modal" id="terms-anchor"
                                                   data-target="#terms">@lang('corals-directory-basic::auth.terms')</a>
                                            </strong>
                                        </label>
                                    </div>
                                    @if ($errors->has('terms'))
                                        <span class="help-block"><strong>@lang('corals-directory-basic::auth.accept_terms')</strong></span>
                                    @endif
                                </div>
                                <button type="submit" class="log-submit-btn">
                                    <span>@lang('corals-directory-basic::auth.register')</span></button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @component('components.modal',['id'=>'terms','header'=>\Settings::get('site_name').' Terms and policy'])
        {!! \Settings::get('terms_and_policy') !!}
    @endcomponent
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.js"></script>
    <script type="text/javascript">
        $('#country-div').bind("DOMSubtreeModified", function () {
            $(".countries-input").addClass('form-control');
        });
    </script>

    @php \Actions::do_action('admin_footer_js') @endphp

@endsection

