@extends('layouts.theme')

@section('title',trans('corals-directory-basic::auth.reset_password'))

@section('editable_content')

    <div class="main-register-holder">
        <div class="main-register fl-wrap">
            <div id="tabs-container">
                <div class="tab">
                    <div id="tab-1" class="tab-content">
                        <div class="custom-form">
                            <h4> {{trans('corals-directory-basic::auth.reset_password')}}</h4>
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.request') }}" class="login-form">
                                {{ csrf_field() }}

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label><i class="fa fa-envelope-o"></i> </label>

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
                                    <label><i class="fa fa-lock"></i> </label>

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
                                    <label><i class="fa fa-lock"></i> </label>

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
                                                class="btn log-submit-btn">@lang('corals-directory-basic::auth.reset_password')</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
