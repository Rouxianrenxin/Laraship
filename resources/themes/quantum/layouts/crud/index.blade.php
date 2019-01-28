@extends('layouts.master')

@section('css')
    <style type="text/css">
        .table > thead > tr > th,
        .table > tbody > tr > th,
        .table > tfoot > tr > th,
        .table > thead > tr > td,
        .table > tbody > tr > td,
        .table > tfoot > tr > td {
            vertical-align: middle;
        }

        .dataTableBuilder .item-actions.float-right {
            float: none !important;
            justify-content: center;
            display: flex;
        }
    </style>
@endsection

@section('title', $title)

@section('actions')
    @if(!empty($dataTable->filters()))
        {!! CoralsForm::link('#'.$dataTable->getTableAttributes()['id'].'_filtersCollapse','<i class="fa fa-filter"></i>',['class'=>'btn btn-info','data'=>['toggle'=>"collapse"]]) !!}
    @endif
    @if(!empty($dataTable->bulkActions()))
        {!! $dataTable->bulkActions() !!}
    @endif
    @unless(isset($hideCreate))
        {!! CoralsForm::link(url($resource_url.'/create'), trans('Corals::labels.create'),['class'=>'btn btn-success']) !!}
    @endunless
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @component('components.box',['box_class'=>'box-primary'])
                @if(!empty($dataTable->filters()))
                    <div id="{{ $dataTable->getTableAttributes()['id'] }}_filtersCollapse"
                         class="filtersCollapse collapse">
                        <br/>
                        {!! $dataTable->filters() !!}
                    </div>
                @endif
                <div class="table-responsive m-t-10">
                    {!! $dataTable->table(['class' => 'table table-striped table-bordered','style'=>'width:100%;']) !!}
                </div>
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
    @include('layouts.crud.filters_script')
    {!! $dataTable->assets() !!}
    {!! $dataTable->scripts() !!}
@endsection