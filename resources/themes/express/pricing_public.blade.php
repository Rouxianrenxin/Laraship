@extends('layouts.master')

@section('editable_content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-2">
                {!! $pricing->rendered !!}
            </div>
        </div>
    </div>
    <section class="pricing-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div style="padding: 2rem 6rem !important;">
                        @foreach($products as $product)
                            <div class="center-title">
                                <h2><img src="{{ $product->image }}" alt="{{ $product->name }}"
                                         height="100"/> {{ $product->name }}</h2>
                                <p>{{ $product->description }}</p>
                            </div>
                            {!! \Shortcode::compile( 'pricing',$product->id ) !!}
                            <hr/>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection