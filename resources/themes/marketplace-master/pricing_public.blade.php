@extends('layouts.public')

@section('editable_content')
    @include('partials.page_header',['item'=>$pricing])

    {!! $pricing->rendered !!}
    <section class="my-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @foreach($products as $product)
                        <div class="my-5">
                            <strong class="text-primary" style="font-size: 2em;">
                                {{ $product->name }}
                            </strong>
                            <br/>
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                         style="width:200px;padding:20px;"/>
                                </div>
                                <div class="col-md-10">
                                    <p style="height: 200px;vertical-align: middle;display: table-cell;">{{ $product->description }}</p>
                                </div>
                            </div>
                            {!!   \Shortcode::compile( 'pricing',$product->id ) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
