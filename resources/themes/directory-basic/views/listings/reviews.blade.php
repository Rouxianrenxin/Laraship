@extends('layouts.theme')

@section('title', $title)

@section('editable_content')
    <div class="content">
        <!--section -->
        <section id="sec1">
            <!-- container -->
            <div class="container">
                <!-- profile-edit-wrap -->
                <div class="profile-edit-wrap">
                    <div class="row">
                        <div class="col-md-3">
                                @include('partials.dashboard_sidebar')
                        </div>
                        <div class="col-md-9">
                            <div class="dashboard-list-box fl-wrap">
                                @include('partials.my_listing_reviews')
                            </div>
                            <!-- pagination-->

                        </div>
                    </div>
                </div>
                <!--profile-edit-wrap end -->
            </div>
            <!--container end -->
        </section>
        <div class="limit-box fl-wrap"></div>
        <section class="gradient-bg">
            <div class="cirle-bg">
                <div class="bg" data-bg="{{ Theme::url('/images/bg/circle.png') }}"></div>
            </div>
            <div class="container">
                <div class="join-wrap fl-wrap">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>@lang('corals-directory-basic::labels.dashboard.questions?')</h3>
                        </div>
                        <div class="col-md-4"><a href="{{url('contact-us')}}" class="join-wrap-btn">@lang('corals-directory-basic::labels.dashboard.get_in_touch')<i
                                        class="fa fa-envelope-o"></i></a></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- section end -->
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