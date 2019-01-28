@extends('Notification::mail.master')

@section('body')
    {!! $body??'' !!}
    <img src="{{ url('newsletter/mail-tracker/'.$api_call_id) }}" alt="">
@endsection