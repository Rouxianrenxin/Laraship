@extends('layouts.theme')


@section('editable_content')



    <div class="content">
        <!-- Map -->
        <div class="map-container column-map left-pos-map">
            <div id="map-main"></div>
            <ul class="mapnavigation">
                <li><a href="#" class="prevmap-nav">@lang('corals-directory-basic::labels.partial.previous')</a></li>
                <li><a href="#" class="nextmap-nav">@lang('corals-directory-basic::labels.partial.next')</a></li>
            </ul>
        </div>

        <!-- Map end -->
        <!--col-list-wrap -->
        <div class="col-list-wrap right-list">

            <div class="listsearch-options fl-wrap" id="lisfw">
                <div class="container">
                    @if($userListing = getUserByHash(\Request::get('user')))
                        @include('partials.user')
                    @endif
                    <div class="listsearch-header fl-wrap">
                        <div class="listing-view-layout">
                            <ul>
                                <li><a class="grid active" href="#"><i class="fa fa-th-large"></i></a></li>
                                <li><a class="list" href="#"><i class="fa fa-list-ul"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- listsearch-input-wrap  -->
                @include('partials.listing_filter')
                <!-- list-main-wrap-->
                    <div class="list-main-wrap fl-wrap card-listing">
                        <a class="custom-scroll-link back-to-filters btf-r" href="#lisfw"><i
                                    class="fa fa-angle-double-up"></i><span>@lang('corals-directory-basic::labels.template.listing.back_to_filters')</span></a>
                        <div class="container">
                            <!-- listing-item -->
                            @forelse($listings as $listing)
                                @include('partials.listing_item',compact('listing'))
                            @empty
                                <h4>@lang('corals-directory-basic::labels.template.listing.sorry_no_result')</h4>
                            @endforelse
                            {{$listings->links('partials.paginator')}}
                        </div>
                    </div>
                    <!-- list-main-wrap end-->
                </div>
                <!--col-list-wrap end -->
                <div class="limit-box fl-wrap"></div>
                <!--section -->
            @if(!user())
                @include('partials.join_our_community')
            @endif
            <!--section end -->
            </div>
        </div>
        @stop

        @section('js')
            @parent
            <script type="text/javascript">

                $(document).ready(function () {
                    $("#shop_sort").change(function () {
                        $("#filterSort").val($(this).val());

                        $("#filterForm").submit();
                    })

                    $(".listsearch-input-item input[name='location']").change(function () {
                        $(".filter-tags-wrap").removeClass("display-none");
                    });

                    $("input[name='location_coordinates']").click(function () {
                        $('#lat').val(null);
                        $('#long').val(null);
                    });

                });


                function getLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(showPosition);
                    } else {
                        window.alert('error');
                    }
                }

                function showPosition(position) {
                    $('#lat').val(position.coords.latitude);
                    $('#long').val(position.coords.longitude);
                }


            </script>
@endsection

