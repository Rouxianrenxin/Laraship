@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('zone_create_edit', $website??null) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    {!! CoralsForm::openForm($zone) !!}
    @component('components.box')
        <div class="row">
            <div class="col-md-4">
                {!! CoralsForm::select('website_id','Advert::attributes.zone.website', [], true, null,
                       ['class'=>'select2-ajax','data'=>[
                       'model'=>\Corals\Modules\Advert\Models\Website::class,
                       'columns'=> json_encode(['name']),
                       'selected'=>json_encode([$zone->website_id]),
                        ],'id'=>'websites'],'select2') !!}

                {!! CoralsForm::text('name','Advert::attributes.zone.name',true) !!}
                {!! CoralsForm::text('key','Advert::attributes.zone.key',true) !!}
                {!! CoralsForm::select('dimension','Advert::attributes.zone.dimension', \Advert::getDimensionsList(), true,null,[], 'select2') !!}
                {!! CoralsForm::radio('status', 'Corals::attributes.status', true, trans('Corals::attributes.status_options'))!!}
            </div>
            <div class="col-md-4">
                {!! CoralsForm::select('banners[]','Advert::attributes.zone.banner', [], false, null,
                       ['class'=>'select2-ajax','multiple'=>"multiple",'data'=>[
                       'model'=>\Corals\Modules\Advert\Models\Banner::class,
                       'columns'=> json_encode(['name']),
                       'selected'=>json_encode($zone->banners()->pluck('advert_banners.id')->toArray()),
                       ],'id'=>'banners'],'select2') !!}
            </div>
            <div class="col-md-4">
                {!! CoralsForm::textarea('notes', 'Advert::attributes.zone.notes', false, null,['rows'=>4]) !!}
            </div>
        </div>

        {!! CoralsForm::customFields($zone) !!}

        <div class="row">
            <div class="col-md-12">
                {!! CoralsForm::formButtons() !!}
            </div>
        </div>
    @endcomponent
    {!! CoralsForm::closeForm($zone) !!}
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            setBannersWhereData();

            $(document).on('change', '#dimension', function () {
                setBannersWhereData();
            })
        });

        function setBannersWhereData() {
            var zoneDimension = $("#dimension").val();

            if (zoneDimension.length) {
                $("#banners").data('where', [{"field": "dimension", "operation": "=", "value": zoneDimension}]);
            }
        }
    </script>
@endsection