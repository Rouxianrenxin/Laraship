@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('category_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-6">
            @component('components.box')
                {!! CoralsForm::openForm($category) !!}

                {!! CoralsForm::text('name','CMS::attributes.category.name',true) !!}
                {!! CoralsForm::text('slug','CMS::attributes.category.slug',true) !!}
                {!! CoralsForm::select('belongs_to','CMS::attributes.category.belongs_to', \CMS::getCategoriesBelongsTo(), true) !!}

                {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Corals::attributes.status_options')) !!}

                @if (\Modules::isModuleActive('corals-subscriptions'))
                    {!! CoralsForm::select('subscription_plans[]','CMS::attributes.category.access_plans', [], false, null,
                    ['class'=>'select2-ajax','multiple'=>"multiple",'data'=>[
                    'model'=>\Corals\Modules\Subscriptions\Models\Plan::class,
                    'columns'=> json_encode(['name']),
                    'selected'=>json_encode($category->subscribable_plans(['getData'=>true])->pluck('id')->toArray()),
                    'where'=>json_encode([['field'=>'status','operation'=>'=','value'=>'active']]),
                    ]],'select2') !!}
                @endif

                {!! CoralsForm::customFields($category, 'col-md-12') !!}
                {!! CoralsForm::formButtons() !!}

                {!! CoralsForm::closeForm($category) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection