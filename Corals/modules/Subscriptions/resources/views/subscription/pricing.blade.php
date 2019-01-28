@extends('layouts.master')

@section('title',$title)

@section('content_header')
    @component('components.content_header')

        @slot('page_title')
            {{ $title }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('pricing') }}
        @endslot

    @endcomponent
@endsection

@section('content')
    <div class="row">

        <div class="col-md-12">
            @foreach($products as $product)
                @component('components.box')

                    @php \Actions::do_action('pre_pricing_table',$product) @endphp


                    <strong class="text-primary" style="font-size: 2em;">
                        {{ $product->name }}
                    </strong>
                    <br/>
                    <div class="row">
                        <div class="col-md-2" style="height: 200px;vertical-align: middle;display: table-cell;">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" height="100%"
                                 style="padding:20px;vertical-align: middle;display: table-cell;"/>
                        </div>
                        <div class="col-md-10">
                            <p style="height: 200px;vertical-align: middle;display: table-cell;">{{ $product->description }}</p>
                        </div>
                    </div>
                    {!!   \Shortcode::compile( 'pricing',$product->id ) !!}
                @endcomponent
            @endforeach
        </div>
    </div>
@endsection