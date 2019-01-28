@extends('layouts.crud.index')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('plans',$product) }}
        @endslot
    @endcomponent
@endsection
@section('actions')
    {!! CoralsForm::link(url(route(config('subscriptions.models.feature.resource_route'), ['product' => $product->hashed_id])),'Subscriptions::labels.plan.features',['class'=>'btn btn-primary']) !!}
    @parent
@endsection