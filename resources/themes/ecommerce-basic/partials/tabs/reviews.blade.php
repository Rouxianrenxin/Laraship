<div class="tab-pane fade" id="reviews" role="tabpanel">
@foreach($reviews as $review)
    <!-- Review-->
        <div class="comment">
            <div class="comment-author-ava"><img src="{{ @$review->author->picture_thumb }}"
                                                 alt="Review author"></div>
            <div class="comment-body">
                <div class="comment-header d-flex flex-wrap justify-content-between">
                    <h4 class="comment-title">{{ $review->title }}</h4>
                    <div class="mb-2">
                        @include('partials.components.rating',['rating'=> $review->rating,'rating_count'=>null ])
                    </div>
                </div>
                <p class="comment-text">{{ $review->body }}</p>
                <div class="comment-footer"><span class="comment-meta">{{ @$review->author->name }}</span></div>
            </div>
        </div>
@endforeach

<!-- Review Form-->
    @if(!user())
        <div class="alert alert-info alert-dismissible fade show text-center margin-bottom-1x"><span class="alert-close"
                                                                                                     data-dismiss="alert"></span><i
                    class="icon-layers"></i>@lang('corals-ecommerce-basic::labels.partial.tabs.need_login_review')
        </div>
    @else
        <h5 class="mb-30 padding-top-1x">@lang('corals-ecommerce-basic::labels.partial.tabs.leave_review')</h5>
        {!! Form::open( ['url' => url('shop/'.$product->hashed_id.'/rate'),'method'=>'POST', 'class'=>'ajax-form row','id'=>'checkoutForm','data-page_action'=>"clearForm"]) !!}

        <div class="col-sm-6">
            {!! CoralsForm::text('review_subject','corals-ecommerce-basic::attributes.tab.subject',true) !!}
        </div>

        <div class="col-sm-6">
            {!! CoralsForm::select('review_rating', 'corals-ecommerce-basic::attributes.tab.rating', trans('corals-ecommerce-basic::attributes.tab.rating_option'),true) !!}
        </div>
        <div class="col-12">
            {!! CoralsForm::textarea('review_text','corals-ecommerce-basic::attributes.tab.review',true,null,['rows'=>4]) !!}

        </div>
        <div class="col-12 text-right">
            {!! CoralsForm::button('corals-ecommerce-basic::labels.partial.tabs.submit_review',['class'=>'btn btn-outline-primary'], 'submit') !!}
        </div>
        {!! Form::close() !!}
    @endif
</div>