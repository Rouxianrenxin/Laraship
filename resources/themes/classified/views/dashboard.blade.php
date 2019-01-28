@extends('layouts.master')

@section('title', $title)

@section('hero_area')
    @include('partials.page_header',['content'=> '<h2 class="product-title">'. $title .'</h2>'])
@endsection

@section('content')
    <div class="inner-box">
        <div class="dashboard-box">
            <h2 class="dashbord-title">{{ $title }}</h2>
        </div>
        <div class="dashboard-wrapper">
            <div class="dashboard-sections">
                <div class="d-flex justify-content-start flex-wrap">
                    <div class="dashboardbox">
                        <div class="icon"><i class="lni-write"></i></div>
                        <div class="contentbox">
                            <h2><a href="{{url('classified/user/products?status=')}}">Total Products Posted</a></h2>
                            <h3>({{\Classified::getProductsCount(true)}}) Product(s)</h3>
                        </div>
                    </div>
                    <div class="dashboardbox">
                        <div class="icon"><i class="lni-add-files"></i></div>
                        <div class="contentbox">
                            <h2><a href="{{url('classified/user/products?status=featured')}}">Featured Products</a>
                            </h2>
                            <h3>({{\Classified::getFeaturedProductsCount(true)}}) Featured Product(s)</h3>
                        </div>
                    </div>
                    <div class="dashboardbox">
                        <div class="icon"><i class="lni-add-files"></i></div>
                        <div class="contentbox">
                            <h2><a href="{{url('classified/user/products?status=archived')}}">Archived Products</a>
                            </h2>
                            <h3>({{\Classified::getArchivedProductsCount(true)}}) Archived Product(s)</h3>
                        </div>
                    </div>
                    <div class="dashboardbox">
                        <div class="icon"><i class="lni-add-files"></i></div>
                        <div class="contentbox">
                            <h2><a href="{{url('classified/user/products?status=sold')}}">Sold Products</a></h2>
                            <h3>({{\Classified::getSoldProductsCount(true)}}) Sold Product(s)</h3>
                        </div>
                    </div>
                    <div class="dashboardbox">
                        <div class="icon"><i class="lni-add-files"></i></div>
                        <div class="contentbox">
                            <h2><a href="{{url('classified/wishlist/my')}}">My Wishlist Products</a></h2>
                            <h3>({{\Classified::getMyWishlistsCount()}}) Wishlist Product(s)</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

