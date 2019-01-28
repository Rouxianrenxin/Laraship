<h3 id="reviews">Reviews</h3>
@foreach($reviews as $review)
    <div class="media">
        <img src="{{ @$review->author->picture_thumb }}" width="50" height="50" alt="John Thor" class="rounded-circle">
        <div class="media-body ml-3">
            <h5 class="mb-0">{{ @$review->author->name }}</h5>
            @include('partials.components.rating',['rating'=> $review->rating,'rating_count'=>null ])
            <p>{{ $review->body }}</p>
        </div>
    </div>
@endforeach
@if(!user())
    <div class="alert alert-info alert-dismissible fade show text-center margin-bottom-1x"><span class="alert-close"
                                                                                                 data-dismiss="alert"></span><i
                class="icon-layers"></i>@lang('corals-ecommerce-mimity::labels.partial.tabs.need_login_review')
    </div>
@else
    <div class="text-center">
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#reviewFormModal">Write a
            review
        </button>
    </div>
    <!-- Review Form Modal -->
    <div class="modal fade" id="reviewFormModal" tabindex="-1" role="dialog" aria-labelledby="reviewFormModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="reviewFormModalLabel">@lang('corals-ecommerce-mimity::labels.partial.tabs.leave_review')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open( ['url' => url('shop/'.$product->hashed_id.'/rate'),'method'=>'POST', 'class'=>'ajax-form','id'=>'checkoutForm','data-page_action'=>'site_reload']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! CoralsForm::text('review_subject','corals-ecommerce-mimity::attributes.tab.subject',true) !!}
                    </div>
                    <div class="form-group">
                        {!! CoralsForm::textarea('review_text','corals-ecommerce-mimity::attributes.tab.review',true,null,['rows'=>4]) !!}
                    </div>
                    <div class="form-group">
                        {!! CoralsForm::select('review_rating', 'corals-ecommerce-mimity::attributes.tab.rating', trans('corals-ecommerce-mimity::attributes.tab.rating_option'),true) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    {!! CoralsForm::button('corals-ecommerce-mimity::labels.partial.tabs.submit_review',['class'=>'btn btn-outline-primary','id' => 'submit_btn'], 'submit') !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endif