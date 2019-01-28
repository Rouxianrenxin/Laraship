@extends('layouts.theme')

@section('title','Rest Password')

@section('editable_content')

    <div class="main-register-holder">
        <div class="main-register fl-wrap">
            <div id="tabs-container">
                <div class="tab">
                    <div id="tab-1" class="tab-content">
                        <div class="custom-form">
                            <h4> Rest Password</h4>
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="post" action="{{ route('password.email') }}" id="login-form"
                                  class="login-form">

                                {{ csrf_field() }}
                                <div class="form-group text-center">
                                    @if(session('confirmation_user_id'))
                                        <a href="{{ route('auth.resend_confirmation') }}">@lang('User::labels.confirmation.resend_email')</a>
                                    @endif
                                </div>
                                <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label><i class="fa fa-envelope-o"></i> </label>

                                    <input name="email" type="text" value="{{ old('email') }}"
                                           placeholder="@lang('User::attributes.user.email')" autofocus>

                                    @if ($errors->has('email'))
                                        <div class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <button type="submit" class="log-submit-btn"><span>Send Password Rest Link</span>
                                </button>
                                <div class="clearfix"></div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection