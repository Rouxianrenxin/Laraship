@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('ecommerce_product_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            @component('components.box',['box_class'=>'box-success'])
                @if($product->type=="variable")
                    <p class="pull-left">
                        <a href="{{url($resource_url.'/'.$product->hashed_id.'/sku')}}"><span
                                    class="label label-info">{{$product->sku->count()  }}
                                @lang('Ecommerce::labels.product.variations') </span></a>
                    </p>
                @endif
                <div class="">
                    <img src="{{ $product->image }}" class="img-responsive" alt="Product Image"
                         style="max-height: 300px;max-width: 90%;"/>
                </div>
                <div class="table-responsive">
                    <table class="table color-table info-table table table-hover table-striped table-condensed">
                        <tbody>
                        <tr>
                            <td width="100">@lang('Ecommerce::attributes.product.name')</td>
                            <td>{!! $product->present('plain_name') !!}</td>
                        </tr>
                        <tr>
                            <td>@lang('Ecommerce::attributes.product.price')</td>
                            <td>{!! $product->price !!}</td>
                        </tr>
                        <tr>
                            <td>@lang('Ecommerce::attributes.product.caption')</td>
                            <td>{{ $product->caption }}</td>
                        </tr>
                        <tr>
                            <td>@lang('Corals::attributes.status')</td>
                            <td><b>{!! $product->present('status') !!}</b></td>
                        </tr>
                        <tr>
                            <td>@lang('Ecommerce::attributes.product.categories')</td>
                            <td><b>{!! $product->present('categories')  !!}</b></td>
                        </tr>
                        <tr>
                            <td>@lang('Ecommerce::attributes.product.tags')</td>
                            <td><b>{!!  $product->present('tags')  !!}</b></td>
                        </tr>
                        <tr>
                            <td>@lang('Ecommerce::attributes.product.properties')</td>
                            <td><b>{!! formatArrayAsLabels($product->properties,'default','',true)  !!}</b></td>
                        </tr>
                        <tr>
                            <td colspan="2">@lang('Ecommerce::attributes.product.description')</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {!! $product->description  !!}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endcomponent
        </div>
        <div class="col-md-8">
            @component('components.box')
                @include('Ecommerce::products.gallery',['product'=>$product,'editable'=>true])
            @endcomponent
        </div>
    </div>
@endsection