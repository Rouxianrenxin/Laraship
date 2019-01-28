@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('campaign_create_edit', $advertiser??null) }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-8">
            @component('components.box')
                {!! CoralsForm::openForm($campaign) !!}
                <div class="row">
                    <div class="col-md-6">
                        @if (user()->hasPermissionTo('Advert::advertiser.view'))

                            {!! CoralsForm::select('advertiser_id','Advert::attributes.campaign.advertiser', [], true, null,
                           ['class'=>'select2-ajax','data'=>[
                           'model'=>\Corals\Modules\Advert\Models\Advertiser::class,
                           'columns'=> json_encode(['name']),
                           'selected'=>json_encode([$campaign->advertiser_id]),
                            ],'id'=>'advertisers'],'select2') !!}

                        @endif
                        {!! CoralsForm::text('name','Advert::attributes.campaign.name',true) !!}

                        {!! CoralsForm::radio('status', 'Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}
                        {!! CoralsForm::number('weight','Advert::attributes.campaign.weight', true, null, ['min'=>1]) !!}
                        {!! CoralsForm::date('starts_at','Advert::attributes.campaign.starts_at', true) !!}
                        {!! CoralsForm::date('ends_at','Advert::attributes.campaign.ends_at', false, $campaign->ends_at, ['help_text'=> 'Advert::attributes.campaign.ends_at_help']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::select('limit_type','Advert::attributes.campaign.limit_type', get_array_key_translation(config('advert.models.campaign.limit_types')), false) !!}

                        {!! CoralsForm::number('limit_per_day','Advert::attributes.campaign.limit_per_day', false, null, [
                            'min'=>0,
                            'help_text'=> 'Advert::attributes.campaign.limit_per_day_help'
                        ]) !!}

                        {!! CoralsForm::textarea('notes', 'Advert::attributes.campaign.notes', false, null,['rows'=>4]) !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($campaign, 'col-md-12') !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>

                {!! CoralsForm::closeForm($campaign) !!}
            @endcomponent
        </div>
    </div>
@endsection