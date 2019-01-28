@extends('layouts.theme')

@section('editable_content')
    <div class="content">
        <section id="sec1">
            <div class="container">
                <div class="profile-edit-wrap">

                    <div class="row">
                        <div class="col-md-3">
                            @include('partials.dashboard_sidebar')
                        </div>
                        <div class="col-md-9">
                            <div class="profile-edit-container">
                                <!-- statistic-container-->
                               @include('partials.dashboard_header')

                                <!--Users Listings' -->
                            @include('partials.my_listings')
                            <!-- Users Listings' end-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="limit-box fl-wrap"></div>

    </div>
@endsection

