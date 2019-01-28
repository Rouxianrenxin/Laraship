@extends('layouts.auth')

@section('title','Reset Password')


@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="container">
        <form class="sign-in-form" method="POST" id="recoverform" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <div class="card">
                <div class="card-body">
                    <a href="{{ url('/') }}" class="brand text-center d-block m-b-20">
                        <img src="{{ \Settings::get('site_logo') }}"
                             alt="{{ \Settings::get('site_name') }}"
                             class="img-fluid" style="max-width: 200px;"/>
                    </a>
                    <h5 class="sign-in-heading text-center">@lang('corals-quantum-admin::labels.auth.reset_password')</h5>
                    <p class="text-center text-muted">@lang('corals-quantum-admin::labels.auth.reset_message')</p>
                    <div class="form-group text-center">
                        @if(session('confirmation_user_id'))
                            <a href="{{ route('auth.resend_confirmation') }}">@lang('User::labels.confirmation.resend_email')</a>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="sr-only">@lang('User::attributes.user.email')</label>
                        <input class="form-control" type="email" name="email"
                               placeholder="@lang('User::attributes.user.email')"
                               value="{{ old('email') }}" autofocus
                        />
                        @if ($errors->has('email'))
                            <small class="form-control-feedback">{{ $errors->first('email') }}</small>
                        @endif
                    </div>
                    <button class="btn btn-primary btn-rounded btn-floating btn-block ladda-button"
                            type="submit">@lang('corals-quantum-admin::labels.auth.send_password_reset')</button>
                    <p class="text-muted m-t-25 m-b-0 p-0"><a
                                href="{{ route('register') }}"> @lang('corals-quantum-admin::labels.auth.register_new_account')</a>
                    </p>
                </div>
            </div>
        </form>
    </div>
@endsection
