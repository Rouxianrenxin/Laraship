@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('licence_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-4">
            @component('components.box')
                {!! CoralsForm::openForm($licence) !!}

                {!! CoralsForm::select('licenceable_id','LicenceManager::attributes.licence.product', [], true, null,
                                           ['class'=>'select2-ajax','data'=>[
                                           'model'=>\Corals\Modules\Ecommerce\Models\Product::class,
                                           'columns'=> json_encode(['name']),
                                           'selected'=>json_encode([$licence->licenceable_id]),
                                            ],'id'=>'product_id'],'select2') !!}

                {!! Form::hidden('licenceable_type', \Corals\Modules\Ecommerce\Models\Product::class) !!}

                {!! CoralsForm::number('expiry_period', 'LicenceManager::attributes.licence.expiry_period', false, 0, [
                        'help_text'=>'LicenceManager::attributes.licence.expiry_period_help','min'=>0]) !!}

                {!! CoralsForm::textarea('code', 'LicenceManager::attributes.licence.code', true) !!}

                {!! CoralsForm::select('status', 'Corals::attributes.status', get_array_key_translation(config('licence_manager.models.licence.status_options')), true) !!}

                {!! CoralsForm::customFields($licence) !!}

                {!! CoralsForm::formButtons() !!}

                {!! CoralsForm::closeForm($licence) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection