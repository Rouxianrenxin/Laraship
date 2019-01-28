@extends('layouts.master')

@section('title', $title)

@section('editable_content')
    <section id="sec1">
        <div class="container">
            <div class="profile-edit-wrap">
                <div class="row">
                    <div class="col-md-3">
                        @include('partials.dashboard_sidebar')
                    </div>
                    <div class="col-md-9">
                    @include('partials.dashboard_header')

                    <!--Users Wishlists' -->
                        <div class="dashboard-list-box fl-wrap">
                            <div class="dashboard-header fl-wrap">
                                <h3>@lang('corals-directory-basic::labels.dashboard.my_wishlists')</h3>
                            </div>
                            @forelse($wishlists as $wishlist)
                                <div class="dashboard-list" id="{{'row_'.$wishlist->hashed_id}}">
                                    <div class="dashboard-message">
                                        <div class="dashboard-listing-table-image">
                                            <a href="{{url('listings/'.$wishlist->wishlistable->slug)}}"><img
                                                        src="{{$wishlist->wishlistable->image}}" alt=""></a>
                                        </div>
                                        <div class="dashboard-listing-table-text">
                                            <h4>
                                                <a href="{{url('listings/'.$wishlist->wishlistable->slug)}}">{{$wishlist->wishlistable->name}}</a>
                                            </h4>
                                            <span class="dashboard-listing-table-address"><i
                                                        class="fa fa-map-marker"></i><a
                                                        href="#">{{$wishlist->wishlistable->address}}</a></span>

                                            <ul class="dashboard-listing-table-opt  fl-wrap">
                                                <li><a href="{{url('utilities/wishlist/'.$wishlist->hashed_id)}}"
                                                       data-action="delete"
                                                       data-page_action="removeRow"
                                                       data-action_data="{{ $wishlist->hashed_id }}"
                                                       class="del-btn">@lang('corals-directory-basic::labels.dashboard.delete')
                                                        <i class="fa fa-trash-o"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info alert-dismissible fade show text-center margin-bottom-1x"><span
                                            class="alert-close"
                                            data-dismiss="alert"></span><i class="fa fa-exclamation-circle"
                                                                           aria-hidden="true"></i>
                                    @lang('corals-directory-basic::labels.dashboard.sry_nothing_to_show')
                                </div>
                            @endforelse
                        </div>

                    {!! $wishlists->links('partials.paginator') !!}
                    <!-- Users Wishlists' end-->
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <div class="limit-box fl-wrap"></div>

@endsection

@section('js')
    <script type="text/javascript">
        function removeRow(response, $form, hashedId) {
            $("#row_" + hashedId).fadeOut();
        }
    </script>
@endsection