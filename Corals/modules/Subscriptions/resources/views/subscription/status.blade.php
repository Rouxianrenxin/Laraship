@extends('layouts.master')

@section('title',$title)

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3 offset-md-3">
            @component('components.box')
                <h4>{!! $message !!}</h4>
                <div class="text-right">
                    {!! CoralsForm::link(url('dashboard'), 'Subscriptions::labels.subscription.continue',['class'=>'btn btn-success']) !!}
                </div>
            @endcomponent
        </div>
    </div>
@endsection