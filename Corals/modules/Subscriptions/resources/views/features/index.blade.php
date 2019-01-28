@extends('layouts.crud.index')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('features',$product) }}
        @endslot
    @endcomponent
@endsection
@section('actions')
    {!! CoralsForm::link(url(route(config('subscriptions.models.plan.resource_route'), ['product' => $product->hashed_id])),'Subscriptions::labels.feature.plan',['class'=>'btn btn-primary']) !!}
    @parent
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                <div class="text-info">
                    <i class="fa fa-info-circle"></i> @lang('Subscriptions::labels.feature.can_drop_table_row')

                </div>
            @endcomponent
        </div>
    </div>

    @parent
@endsection