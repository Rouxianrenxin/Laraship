@extends('layouts.master')

@section('title', $title)

@section('hero_area')
    @include('partials.page_header', ['content'=> '<h2 class="product-title">'. $title .'</h2>'])
@endsection

@section('content')
    <div class="inner-box">
        <div class="dashboard-box">
            <h2 class="dashbord-title">{{ $title }}</h2>
        </div>
        <div class="dashboard-wrapper">
            <nav class="nav-table">
                <ul>
                    <li class="{{checkActiveKey('','status')?'active':''}}"><a
                                href="{{url('classified/user/products?status=')}}">All Products
                            ({{\Classified::getProductsCount(true)}})</a></li>
                    <li class="{{checkActiveKey('active','status')?'active':''}}"><a
                                href="{{url('classified/user/products?status=active')}}">Active
                            ({{\Classified::getActiveProductsCount(false,true)}})</a></li>
                    <li class="{{checkActiveKey('sold','status')?'active':''}}"><a
                                href="{{url('classified/user/products?status=sold')}}">Sold
                            ({{\Classified::getSoldProductsCount(true)}})</a></li>
                    <li class="{{checkActiveKey('featured','status')?'active':''}}"><a
                                href="{{url('classified/user/products?status=featured')}}">Featured
                            ({{\Classified::getFeaturedProductsCount(true)}})</a></li>
                    <li class="{{checkActiveKey('archived','status')?'active':''}}"><a
                                href="{{url('classified/user/products?status=archived')}}">Archived
                            ({{\Classified::getArchivedProductsCount(true)}})</a></li>
                </ul>
            </nav>
            <div class="table-responsive">
                <table class="table  dashboardtable tablemyads">
                    <thead>
                    @if(!$products->isEmpty())
                        <tr>
                            <th>@lang('Classified::attributes.product.image')</th>
                            <th>@lang('Classified::attributes.product.name')</th>
                            <th>@lang('Classified::attributes.product.location')</th>
                            <th>@lang('Classified::attributes.product.price')</th>
                            <th>@lang('Classified::attributes.product.categories')</th>
                            <th>@lang('Corals::attributes.status')</th>
                            <th>@lang('Corals::labels.action')</th>
                        </tr>
                    @endif
                    </thead>
                    <tbody>
                    @forelse($products as $product)
                        <tr data-category="active" id="{{'row_'.$product->hashed_id}}">
                            <td class="photo">{!!$product->present('image') !!}</td>
                            <td class="productName">

                                <a href="{{url('products/'.$product->slug)}}" target="_blank">
                                    <h3>{!! $product->name !!}</h3></a>
                                <span>{!! $product->present('caption') !!}</span>
                            </td>
                            <td><span class="adcategories">{!! $product->present('location') !!}</span></td>
                            <td><h3>{!! $product->present('price') !!}</h3></td>
                            <td><span class="adcategories">{!! $product->present('categories') !!}</span></td>
                            <td><span class="adstatus adstatusactive">{!! $product->present('status') !!}</span>
                            </td>
                            <td>
                                <div class="btns-actions">
                                    <a class="btn-action btn-view" href="{{url('products/'.$product->slug)}}"
                                       target="_blank"><i
                                                class="lni-eye"></i></a>
                                    <a class="btn-action btn-edit"
                                       href="{{url('classified/user/products/'.$product->hashed_id.'/edit')}}"><i
                                                class="lni-pencil"></i></a>
                                    <a class="btn-action btn-delete"
                                       href="{{url('classified/user/products/'.$product->hashed_id)}}"
                                       data-action="delete"
                                       data-page_action="removeRow" data-action_data="{{ $product->hashed_id }}"><i
                                                class="lni-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        Sorry, Nothing to Show!
                    @endforelse
                    </tbody>
                </table>
            </div>

            {!! $products->links('partials.paginator') !!}
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type="text/javascript">
        function removeRow(response, $form, hashedId) {
            $("#row_" + hashedId).fadeOut();
        }
    </script>
@endsection