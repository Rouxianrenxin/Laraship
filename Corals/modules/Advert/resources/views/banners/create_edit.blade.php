@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('banner_create_edit', $campaign??null) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($banner, ['files'=>true]) !!}
                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::select('campaign_id','Advert::attributes.banner.campaign', [], true, null,
                       ['class'=>'select2-ajax','data'=>[
                       'model'=>\Corals\Modules\Advert\Models\Campaign::class,
                       'columns'=> json_encode(['name']),
                       'selected'=>json_encode([$banner->campaign_id]),
                        ],'id'=>'campaigns'],'select2') !!}

                        {!! CoralsForm::text('name','Advert::attributes.banner.name',true) !!}

                        {!! CoralsForm::radio('status', 'Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}

                        {!! CoralsForm::select('dimension','Advert::attributes.banner.dimension', \Advert::getDimensionsList(), true,null,[], 'select2') !!}
                        {!! CoralsForm::number('weight','Advert::attributes.banner.weight', true, null, ['min'=>1]) !!}
                        {!! CoralsForm::text('url','Advert::attributes.banner.url') !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::select('type','Advert::attributes.banner.type', get_array_key_translation(config('advert.models.banner.types')), true,null) !!}
                        <div id="type_media" class="banner-type-details" style="display: none;">
                            {!! CoralsForm::file('media', 'Advert::labels.banner.media',true) !!}
                            @if($banner->objectUrl)
                                <img src="{{ $banner->objectUrl }}" class="img-responsive" style="max-width: 100%;"
                                     alt="Media"/>
                            @endif
                        </div>
                        <div id="type_script" class="banner-type-details" style="display: none;">
                            {!! CoralsForm::textarea('script', 'Advert::labels.banner.script', true, $banner->content,['rows'=>7]) !!}
                        </div>
                        <div id="type_link" class="banner-type-details" style="display: none;">
                            {!! CoralsForm::text('link', 'Advert::labels.banner.link', true, $banner->content) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::select('zones[]','Advert::attributes.banner.zone', [], false, null,
                               ['class'=>'select2-ajax','multiple'=>"multiple",'data'=>[
                               'model'=>\Corals\Modules\Advert\Models\Zone::class,
                               'columns'=> json_encode(['name']),
                               'selected'=>json_encode($banner->zones()->pluck('advert_zones.id')->toArray()),
                               ],'id'=>'zones'],'select2') !!}

                        {!! CoralsForm::textarea('notes', 'Advert::attributes.banner.notes', false, null,['rows'=>4]) !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($banner) !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm() !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            var $bannerType = $("#type");

            $bannerType.change(function (event) {
                var $ele = $(this);

                $('.banner-type-details').hide();

                $('#type_' + $ele.val()).fadeIn();
            });

            $('#type_' + $bannerType.val()).fadeIn();
        });
    </script>
@endsection