@extends('layouts.auth')

@section('title',trans('corals-classified-master::auth.reset_password'))

@section('hero_area')
    @include('partials.page_header',['content'=> '<h2 class="product-title">'.trans('corals-classified-master::auth.reset_password').'</h2>'])
@endsection

@section('content')
    <div class="login section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="login-form login-area">
                        <h3 class="login-box-msg">@lang('corals-classified-master::auth.reset_password')</h3>
                        <form method="POST" action="{{ route('password.request') }}" class="login-form">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" name="email"
                                       class="form-control" placeholder="@lang('User::attributes.user.email')"
                                       value="{{ old('email') }}"/>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                                @if ($errors->has('email'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password" name="password" class="form-control"
                                       placeholder="@lang('User::attributes.user.password')"/>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                                @if ($errors->has('password'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <input type="password" name="password_confirmation" class="form-control"
                                       placeholder="@lang('User::attributes.user.retype_password')"/>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                                @if ($errors->has('password_confirmation'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="row justify-content-center">
                                <!-- /.col -->
                                <div class="col-xs-12">
                                    <button type="submit"
                                            class="btn btn-primary btn-block btn-flat">@lang('corals-classified-master::auth.reset_password')</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
