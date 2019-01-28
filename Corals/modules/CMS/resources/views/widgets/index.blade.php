@extends('layouts.crud.index')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('widgets',$block) }}
        @endslot
    @endcomponent
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                <div class="text-info">
                    <i class="fa fa-info-circle"></i> @lang('CMS::labels.widget.can_drop_table_row')

                </div>
            @endcomponent
        </div>
    </div>

    @parent
@endsection