@extends('layouts.crud.show')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @component('components.box',['box_class'=>'box-success'])
                <div class="well" style="min-height: 200px;">
                    <div class="media pull-left">
                        <a class="pull-left" href="#">
                            <img class="img-responsive" style="display: inline;" width="150"
                                 src="{{ asset($product->image) }}"
                                 alt="Product Image"> </a>
                    </div>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{ $product->name }}</h4>
                        <p>{{ $product->description }}</p>
                    </div>
                </div>
        </div>
        @endcomponent
    </div>
    </div>
@endsection