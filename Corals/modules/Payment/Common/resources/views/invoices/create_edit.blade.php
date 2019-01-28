@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('invoice_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-10">
            @component('components.box')
                {!! CoralsForm::openForm($invoice) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('code','Payment::attributes.invoice.invoice_code',true) !!}
                        {!! CoralsForm::date('due_date','Payment::attributes.invoice.due_date', true, $invoice->due_date) !!}
                        {!! CoralsForm::radio('status','Corals::attributes.status',true, get_array_key_translation(config('payment_common.models.invoice.statuses'))) !!}
                        {!! CoralsForm::select('currency', 'Payment::attributes.invoice.currency', \Payments::getActiveCurrenciesList() , true, null, $invoice->exists?[]:[]) !!}
                        {!! CoralsForm::select('user_id','Payment::attributes.invoice.user_id', [], true, null,
                                   ['class'=>'select2-ajax','data'=>[
                                   'model'=>\Corals\User\Models\User::class,
                                   'columns'=> json_encode(['name','last_name', 'email']),
                                   'selected'=>json_encode($invoice->user_id?[$invoice->user_id]:($invoicable ? [$invoicable->user->id] :[])),
                                   'where'=>json_encode([]),
                                   ]],'select2') !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::number('sub_total','Payment::attributes.invoice.sub_total',true,$invoice->sub_total?$invoice->sub_total:0,
array_merge(['help_text'=>'','right_addon'=>'<i class="'.$invoice->currency.'"></i>',
'step'=>0.01,'min'=>0,'max'=>99999999],$invoice->exists?[]:[])) !!}
                        {!! CoralsForm::number('total','Payment::attributes.invoice.total',true,$invoice->total?$invoice->total:0,
                        array_merge(['help_text'=>'','right_addon'=>'<i class="'.$invoice->currency.'"></i>',
                        'step'=>0.01,'min'=>0,'max'=>99999999],$invoice->exists?[]:[])) !!}
                        {!! CoralsForm::textarea('description','Payment::attributes.invoice.description',false) !!}
                        @isset($invoicable)
                            <input type="hidden" name="invoicable_id" value="{{ $invoicable->id }}"/>
                            <input type="hidden" name="invoicable_hashed_id" value="{{ $invoicable->hashed_id }}"/>
                            <input type="hidden" name="invoicable_type" value="{{ get_class ($invoicable) }}"/>
                            <input type="hidden" name="invoicable_resource_url" value="{{ $invoicable_resource_url }}"/>

                        @endisset
                    </div>

                </div>
                {!! CoralsForm::customFields($invoice,'col-md-6') !!}
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($invoice) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection
