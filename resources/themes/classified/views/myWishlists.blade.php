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

            <div class="table-responsive">
                <table class="table  dashboardtable tablemyads">
                    <thead>
                    @if(!$wishlists->isEmpty())
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
                    @forelse($wishlists as $wishlist)
                        <tr data-category="active" id="{{'row_'.$wishlist->hashed_id}}">
                            <td class="photo">{!!$wishlist->wishlistable->present('image') !!}</td>
                            <td class="productName">

                                <a href="{{url('products/'.$wishlist->wishlistable->slug)}}" target="_blank">
                                    <h3>{!! $wishlist->wishlistable->name !!}</h3></a>
                                <span>{!! $wishlist->wishlistable->present('caption') !!}</span>
                            </td>
                            <td><span class="adcategories">{!! $wishlist->wishlistable->present('location') !!}</span>
                            </td>
                            <td><h3>{!! $wishlist->wishlistable->present('price') !!}</h3></td>
                            <td><span class="adcategories">{!! $wishlist->wishlistable->present('categories') !!}</span>
                            </td>
                            <td>
                                <span class="adstatus adstatusactive">{!!  $wishlist->wishlistable->present('status') !!}</span>
                            </td>
                            <td>
                                <div class="btns-actions">
                                    <a class="btn-action btn-view"
                                       href="{{url('products/'.$wishlist->wishlistable->slug)}}"
                                       target="_blank"><i
                                                class="lni-eye"></i></a>
                                    <a class="btn-action btn-delete"
                                       href="{{url('utilities/wishlist/'.$wishlist->hashed_id)}}"
                                       data-action="delete"
                                       data-page_action="removeRow" data-action_data="{{$wishlist->hashed_id}}"><i
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


            {!! $wishlists->links('partials.paginator') !!}
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type="text/javascript">

        function removeRow(respnse, $form, hashed_id) {
            $("#row_" + hashed_id).fadeOut();
        }
    </script>
@endsection