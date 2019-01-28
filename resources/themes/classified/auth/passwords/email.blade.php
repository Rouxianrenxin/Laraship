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

                        <h3>@lang('corals-classified-master::auth.reset_password')</h3>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form method="post" action="{{ route('password.email') }}" class="login-form" id="login-form">
                            {{ csrf_field() }}
                            <div class="form-group text-center">
                                @if(session('confirmation_user_id'))
                                    <a href="{{ route('auth.resend_confirmation') }}">@lang('User::labels.confirmation.resend_email')</a>
                                @endif
                            </div>
                            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" name="email"
                                       class="form-control" placeholder="Email"
                                       value="{{ old('email') }}" autofocus/>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                                @if ($errors->has('email'))
                                    <div class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="row justify-content-center">
                                <!-- /.col -->
                                <div class="col-xs-12">
                                    <button type="submit"
                                            class="btn btn-primary btn-block btn-flat">@lang('corals-classified-master::auth.send_password_reset')</button>
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
