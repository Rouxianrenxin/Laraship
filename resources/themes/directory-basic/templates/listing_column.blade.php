@extends('layouts.theme')

@section('editable_content')
    <div class="map-container column-map right-pos-map">
        <div id="map-main"></div>
        <ul class="mapnavigation">
            <li><a href="#" class="prevmap-nav">@lang('corals-directory-basic::labels.partial.previous')</a></li>
            <li><a href="#" class="nextmap-nav">@lang('corals-directory-basic::labels.partial.next')</a></li>
        </ul>
    </div>
    <!-- Map end -->
    <!--col-list-wrap -->
    <div class="col-list-wrap left-list">
        <div class="listsearch-options fl-wrap" id="lisfw">
            <div class="container">
                <div class="listsearch-header fl-wrap">
                    <h3>@lang('corals-directory-basic::labels.template.listing.result_for'):</h3>
                    <div class="listing-view-layout">
                        <ul>
                            <li><a class="grid active" href="#"><i class="fa fa-th-large"></i></a></li>
                            <li><a class="list" href="#"><i class="fa fa-list-ul"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- listsearch-input-wrap  -->
                <div class="listsearch-input-wrap fl-wrap">
                    <form id="filterForm">
                        <div class="listsearch-input-item">
                            <i class="mbri-key single-i"></i>
                            <input type="text"
                                   placeholder="@lang('corals-directory-basic::labels.template.listing.keywords'):"
                                   value=""/>
                        </div>
                        <div class="listsearch-input-item">
                            @php
                                $locations = \Corals\Modules\Directory\Facades\Directory::getLocationsList()
                            @endphp
                            <select data-placeholder="Location" name="location">
                                <option value=""
                                        selected>@lang('corals-directory-basic::labels.template.listing.location')</option>
                                @foreach($locations as $location)
                                    <option value="{{$location}}">{{$location}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="listsearch-input-item">
                            <select data-placeholder="All Categories" name="category">
                                <option value=""
                                        selected>@lang('corals-directory-basic::labels.template.listing.category')</option>
                                @foreach(\Corals\Modules\Directory\Facades\Directory::getActiveCategories() as $activeCategory)
                                    <option value="{{$activeCategory->name}}">{{$activeCategory->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- hidden-listing-filter -->
                        <div class="hidden-listing-filter fl-wrap">
                            <div class="distance-input fl-wrap">
                                <div class="distance-title"> Radius around selected destination <span></span> km</div>
                                <div class="distance-radius-wrap fl-wrap">
                                    <input class="distance-radius rangeslider--horizontal" type="range" min="1"
                                           max="100" step="1" value="1" data-title="Radius around selected destination">
                                </div>
                            </div>
                            <!-- Checkboxes -->
                            <div class=" fl-wrap filter-tags">
                                <h4>@lang('corals-directory-basic::labels.template.listing.tag')</h4>
                                @foreach(\Corals\Modules\Directory\Facades\Directory::getTagsList() as $tag)
                                    <div class="filter-tags-wrap">
                                        <input id="check-a" type="checkbox" name="tag" value="{{$tag}}">
                                        <label for="check-a">{{$tag}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- hidden-listing-filter end -->
                        <button type="submit" class="button fs-map-btn">@lang('corals-directory-basic::labels.template.listing.filter')</button>
                        <div class="more-filter-option">@lang('corals-directory-basic::labels.template.listing.more_filter')<span></span></div>
                    </form>
                </div>
                <!-- listsearch-input-wrap end -->
            </div>
        </div>
        <!-- list-main-wrap-->
        <div class="list-main-wrap fl-wrap card-listing">
            <a class="custom-scroll-link back-to-filters btf-l" href="#lisfw"><i
                        class="fa fa-angle-double-up"></i><span>@lang('corals-directory-basic::labels.template.listing.back_filter')</span></a>
            <div class="container">
                <!-- listing-item -->
                @forelse($listings as $listing)
                    <div class="listing-item">
                        <article class="geodir-category-listing fl-wrap">
                            <div class="geodir-category-img">
                                <img src="{{$listing->image}}" alt="Listing">
                                <div class="overlay"></div>
                                <div class="list-post-counter"><span>4</span><i class="fa fa-heart"></i></div>
                            </div>
                            <div class="geodir-category-content fl-wrap">
                                <a class="listing-geodir-category" href="">{{$listing->name}}</a>
                                <div class="listing-avatar"><a href=""><img
                                                src="{{$listing->user->picture_thumb}}" alt=""></a>
                                    <span class="avatar-tooltip">Added By  <strong>{{$listing->user->full_name}}</strong></span>
                                </div>
                                <h3><a href="">{{$listing->name}}</a></h3>
                                <p>{!! $listing->description !!}</p>
                                <div class="geodir-category-options fl-wrap">
                                    <div class="listing-rating card-popup-rainingvis" data-starrating2="5">
                                        <span>(7 reviews)</span>
                                    </div>
                                    <div class="geodir-category-location"><a href="#0" class="map-item"><i
                                                    class="fa fa-map-marker" aria-hidden="true"></i>{{$listing->location->name}}</a></div>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <h4>@lang('corals-directory-basic::labels.template.listing.sorry_no_result')</h4>
            @endforelse
            <!-- listing-item end-->
            </div>
            <a class="load-more-button" href="#">Load more <i class="fa fa-circle-o-notch"></i> </a>
        </div>
        <!-- list-main-wrap end-->
    </div>
    <!--col-list-wrap -->
    <div class="limit-box fl-wrap"></div>
    <!--section -->
    <section class="gradient-bg">
        <div class="cirle-bg">
            <div class="bg" data-bg="{{ Theme::url('/images/bg/circle.png') }}"></div>
        </div>
        <div class="container">
            <div class="join-wrap fl-wrap">
                <div class="row">
                    <div class="col-md-8">
                        <h3>Join our online community</h3>
                        <p>Grow your marketing and be happy with your online business</p>
                    </div>
                    <div class="col-md-4"><a href="#" class="join-wrap-btn modal-open">Sign Up <i
                                    class="fa fa-sign-in"></i></a></div>
                </div>
            </div>
        </div>
    </section>
    <!--section end -->


@endsection

@section('js')
    @parent
    @include('Ecommerce::cart.cart_script')

    <script type="text/javascript">
        $(document).ready(function () {
            $("#shop_sort").change(function () {
                $("#filterSort").val($(this).val());

                $("#filterForm").submit();
            })
        });
    </script>
@endsection