@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_shop') }}
        @endslot
    @endcomponent
@endsection

@section('css')
    <style type="text/css">
        .badge {
            font-size: 8px;
        }

        .sku-item .label, .sku-item .add-to-cart {
            font-size: small;
            font-weight: 600;
        }

        .sku-item .add-to-cart {
        }

        .img-radio {
            max-height: 100px;
            margin: 5px auto;
        }

        .middle {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .selected-radio > img {
            opacity: .45;
        }

        .selected-radio .middle {
            opacity: 1;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @component('components.box',['box_class'=>'box-success'])
                <div class="text-center">
                    <img src="{{ $product->image }}" class="img-responsive" alt="Product Image"/>
                </div>
                <div class="text-center">
                    <h2>
                        @if($product->discount)
                            <del>{{ \Payments::currency($product->regular_price) }}</del>
                        @endif
                        {!! $product->price !!}
                    </h2>
                    <h4><b>{!! $product->present('plain_name') !!}</b></h4>

                    <h4>{{ $product->caption }}</h4>
                </div>
                <div style="">
                    {!! $product->description !!}
                </div>
            @endcomponent
        </div>
        <div class="col-md-4">
            @component('components.box',['box_class'=>'box-success'])
                {!! Form::open(['url'=>'cart/'.$product->hashed_id.'/add-to-cart','method'=>'POST','class'=> 'ajax-form','data-page_action'=>"updateCart"]) !!}
                @if(!$product->isSimple)
                    @foreach($product->activeSKU as $sku)
                        @if($loop->index%2 == 0)
                            <div class="row">
                                @endif
                                <div class="col-md-6 text-center">
                                    <img src="{{ asset($sku->image) }}" class="img-responsive img-radio">
                                    <div class="middle">
                                        <div class="text text-success"><i class="fa fa-check fa-4x"></i></div>
                                    </div>
                                    <div>
                                        {!! !$sku->options->isEmpty() ? $sku->present('options'):'' !!}
                                    </div>
                                    @if($sku->stock_status == "in_stock")
                                        <button type="button"
                                                class="btn btn-block btn-sm btn-default btn-secondary btn-radio m-t-5">
                                            <b>{!! \Payments::currency($sku->price)  !!}</b>
                                        </button>
                                    @else
                                        <button type="button"
                                                class="btn btn-block btn-sm m-t-5 btn-danger">
                                            <b>@lang('Ecommerce::labels.shop.out_stock')</b>
                                        </button>

                                    @endif

                                    <input type="checkbox" id="left-item" name="sku_hash" value="{{ $sku->hashed_id }}"
                                           class="hidden disable-icheck"/>
                                </div>
                                @if($lastLoop = $loop->index%2 == 1)
                            </div>
                        @endif
                    @endforeach
                    @if(!$lastLoop)</div>@endif
        @else
            <input type="hidden" name="sku_hash" value="{{ $product->activeSKU(true)->hashed_id }}"/>
        @endif
        <div class="form-group">
            <span data-name="sku_hash"></span>
        </div>
        <div class="row m-t-20">
            <div class="col-md-4">
                {!! CoralsForm::number('quantity','Ecommerce::attributes.shop.quantity', false, 1, ['min' => 1]) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if($product->globalOptions->count())
                    {!! $product->renderProductOptions('global_options' ) !!}
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if($product->external_url)
                    <a href="{{ $product->external_url }}" target="_blank" class="btn btn-default btn-block m-t-10 "
                       title="Buy Product">
                        <i class="fa fa-fw fa-cart-plus" aria-hidden="true"></i> @lang('Ecommerce::labels.shop.buy')
                    </a>
                @elseif($product->isSimple && $product->activeSKU(true)->stock_status != "in_stock")
                    <button type="button"
                            class="btn btn-block btn-sm m-t-5 btn-danger">
                        <b>@lang('Ecommerce::labels.shop.out_stock')</b>
                    </button>
                @else
                    {!! CoralsForm::formButtons('Ecommerce::labels.shop.add_cart',['class'=>'btn btn-default btn-block m-t-10 add-to-cart'], ['show_cancel'=>false]) !!}
                @endif
            </div>
        </div>

        {{ Form::close() }}
        @endcomponent
    </div>
    @if($product->getMedia('ecommerce-product-gallery')->count())
        <div class="col-md-4">
            @component('components.box')
                @include('Ecommerce::products.gallery',['product'=>$product,'editable'=>false])
            @endcomponent
        </div>
    @endif
@endsection

@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')
@endsection