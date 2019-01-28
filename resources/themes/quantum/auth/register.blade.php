@extends('layouts.auth')

@section('title',trans('corals-quantum-admin::labels.auth.register'))
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/flags.authy.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.css"/>
@endsection
@section('content')

    <div class="container">
        <form method="POST" action="{{ route('register') }}" class="register-form">
            {{ csrf_field() }}
            <div class="card">
                <div class="card-body">
                    <a href="{{ url('/') }}" class="brand text-center d-block m-b-20">
                        <img src="{{ \Settings::get('site_logo') }}"
                             alt="{{ \Settings::get('site_name') }}"
                             class="img-fluid" style="max-width: 200px;"/>
                    </a>
                    <h5 class="sign-in-heading text-center m-b-20">@lang('corals-quantum-admin::labels.auth.register_new_account')</h5>
                    <div class="row">
                        <div class="col-md-3 p-r-0">
                            <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label for="inputEmail" class="sr-only">@lang('User::attributes.user.name')</label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="@lang('User::attributes.user.name')"
                                       value="{{ old('name') }}" autofocus/>
                                @if ($errors->has('name'))
                                    <small class="form-control-feedback">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 p-r-0">
                            <div class="form-group {{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                <label for="inputEmail" class="sr-only">@lang('User::attributes.user.last_name')</label>
                                <input type="text" name="last_name" class="form-control"
                                       placeholder="@lang('User::attributes.user.last_name')"
                                       value="{{ old('last_name') }}" autofocus/>
                                @if ($errors->has('last_name'))
                                    <small class="form-control-feedback">{{ $errors->first('last_name') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 p-r-0">
                            <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label for="inputEmail" class="sr-only">@lang('User::attributes.user.email')</label>
                                <input type="email" name="email"
                                       class="form-control" placeholder="@lang('User::attributes.user.email')"
                                       value="{{ old('email') }}"/>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                @if ($errors->has('email'))
                                    <small class="form-control-feedback">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 p-r-0">
                            <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                                <label for="inputPassword"
                                       class="sr-only">@lang('User::attributes.user.password')</label>
                                <input type="password" name="password" class="form-control"
                                       placeholder="@lang('User::attributes.user.password')"/>
                                @if ($errors->has('password'))
                                    <small class="form-control-feedback">{{ $errors->first('password') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 p-r-0">
                            <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label for="inputPassword"
                                       class="sr-only">@lang('User::attributes.user.retype_password')</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="@lang('User::attributes.user.retype_password')"/>
                                @if ($errors->has('password_confirmation'))
                                    <small class="form-control-feedback">{{ $errors->first('password_confirmation') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($is_two_factor_auth_enabled = \Settings::get('two_factor_auth_enabled', false))

                        <div id="country-div"
                             class="form-group {{ $errors->has('phone_country_code') ? ' has-danger' : '' }}">
                            <select class="form-control" id="authy-countries" name="phone_country_code"></select>
                            @if ($errors->has('phone_country_code'))
                                <small class="form-control-feedback">{{ $errors->first('phone_country_code') }}</small>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('phone_number') ? ' has-danger' : '' }}">
                            <input class="form-control" id="authy-cellphone"
                                   placeholder="@lang('User::attributes.user.cell_phone_number')" type="text"
                                   value="{{ old('phone_number') }}"
                                   name="phone_number"/>
                            <label>@lang('User::attributes.user.cell_phone_number')</label>

                            @if ($errors->has('phone_number'))
                                <small class="form-control-feedback">{{ $errors->first('phone_number') }}</small>
                            @endif
                        </div>
                    @endif
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" value="1"
                               name="terms"
                               {{ old('terms') ? 'checked' : '' }} class="custom-control-input"
                               id="termsCheckbox"/>
                        <label class="custom-control-label"
                               for="termsCheckbox">
                            <strong>@lang('corals-quantum-admin::labels.auth.agree')
                                <a href="#" data-toggle="modal" id="terms-anchor"
                                   data-target="#terms">@lang('corals-quantum-admin::labels.auth.terms')</a>
                            </strong>
                        </label>
                    </div>
                    @if($errors->has('terms'))
                        <div class="has-danger">
                            <small class="form-control-feedback">@lang('corals-quantum-admin::labels.auth.accept_terms')</small>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 p-r-0">
                            <button class="btn btn-primary btn-rounded btn-floating  btn-block my-2"
                                    type="submit">@lang('corals-quantum-admin::labels.auth.register')</button>

                        </div>
                        <div class="col-md-6 p-r-0">
                            <a class="btn btn-success btn-rounded btn-floating  btn-block my-1"
                               href="{{ route('login') }}">@lang('corals-quantum-admin::labels.auth.already_have_account')</a><br>
                        </div>
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
                </div>

            </div>
        </form>
    </div>
@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/authy-form-helpers/2.3/form.authy.js"></script>
    <script type="text/javascript">
        $('#country-div').bind("DOMSubtreeModified", function () {
            $(".countries-input").addClass('form-control');
            $(".countries-input").trigger('focus');
        });
    </script>
@endsection