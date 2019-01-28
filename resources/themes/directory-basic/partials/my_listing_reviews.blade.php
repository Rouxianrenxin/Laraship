@php
    $reviews = \Corals\Modules\Directory\Facades\Directory::getListingsReviews(user(),true);
@endphp
<div class="dashboard-list-box fl-wrap">
    <div class="dashboard-header fl-wrap">
        <h3>@lang('corals-directory-basic::labels.dashboard.my_reviews')</h3>
    </div>
    <div class="reviews-comments-wrap">
        @forelse( $reviews as $review)
            @include('partials.rating_single',['review'=> $review,'show_name'=>true,'show_status'=>true  ])
        @empty
            <div class="alert alert-info alert-dismissible fade show text-center margin-bottom-1x"><span
                        class="alert-close"
                        data-dismiss="alert"></span><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                @lang('corals-directory-basic::labels.dashboard.sry_nothing_to_show')
            </div>
        @endforelse
    </div>
</div>

{!! $reviews->links('partials.paginator') !!}

<script type="text/javascript">
    function removeRow(response, $form, hashedId) {
        $("#row_" + hashedId).fadeOut();
    }
</script>