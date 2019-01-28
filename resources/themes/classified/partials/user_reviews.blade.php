<div id="comments">
    <div class="comment-box">
        @if(!user())
            <div class="alert alert-info alert-dismissible fade show text-center margin-bottom-1x"><span
                        class="alert-close"
                        data-dismiss="alert"></span><i class="icon-layers"></i>
                @lang('corals-classified-master::labels.partial.tabs.need_login_review')
            </div>
        @elseif(user()->hashed_id != $productUser->hashed_id )
            <a data-toggle="collapse" href="#reviewForm" aria-expanded="false">
                <h6 class="mb-2"><i
                            class="fa fa-plus"></i> @lang('corals-classified-master::labels.partial.tabs.leave_review')</h6>
            </a>

            {!! Form::open( ['url' => url('classified/user/'.\Request::get('user').'/rate'),'method'=>'POST', 'class'=>'ajax-form collapse','id'=>'reviewForm','data-page_action'=>"clearForm"]) !!}
            <hr/>
            <div class="d-flex justify-content-start">
                {!! CoralsForm::text('review_subject','corals-classified-master::attributes.tab.subject',true) !!}
                {!! CoralsForm::select('review_rating', 'corals-classified-master::attributes.tab.rating', trans('corals-classified-master::attributes.tab.rating_option'),true, null,['class'=>'ml-1']) !!}
            </div>

            <div class="">
                {!! CoralsForm::textarea('review_text','corals-classified-master::attributes.tab.review',true,null,['rows'=>2]) !!}

            </div>
            <div class="col-12 text-right">
                {!! CoralsForm::button('corals-classified-master::labels.partial.tabs.submit_review',['class'=>'btn tg-btn'], 'submit') !!}
            </div>
            {!! Form::close() !!}
        @endif
        <hr/>
        <ol class="comments-list">
            @foreach($productUser->ratings as $review)
                <li>
                    <div class="media">
                        <div class="info-body">
                            <div class="media-heading d-flex justify-content-between">
                                <h4 class="name">{{ $review->title }}</h4>
                                <div class="">
                                    @include('partials.components.rating',['rating'=> $review->rating,'rating_count'=>null ])
                                </div>
                                <span class="comment-date">
                                    <i class="lni-alarm-clock"></i> {{$review->created_at->diffForHumans()}}
                                </span>
                            </div>
                            <div>
                                {{ $review->body }}
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</div>




