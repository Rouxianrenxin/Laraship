@extends('layouts.theme')

@section('editable_content')
    @php
        \Actions::do_action('pre_content',$item, $home??null);
    @endphp
    @include('partials.home_page_filter')
    @include('partials.featured_category')
    @include('partials.featured_listing')
    @include('partials.how_its_works')
    @include('partials.static_home_center',compact('item'))
    @include('partials.statistics_home')
    @include('partials.blog')
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
                    <div class="col-md-4"><a href="{{url('contact-us')}}"
                                             class="join-wrap-btn">@lang('corals-directory-basic::labels.dashboard.get_in_touch')
                            <i
                                    class="fa fa-envelope-o"></i></a></div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('js')
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            $("#shop_sort").change(function () {
                $("#filterSort").val($(this).val());

                $("#filterForm").submit();
            })
        });
    </script>
@endsection