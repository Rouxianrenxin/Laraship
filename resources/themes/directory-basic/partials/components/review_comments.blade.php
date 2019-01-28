<div class="row  m-10">
    <div class="col-md-12 text-right">
        @if(user() && user()->can('Utility::comment.create'))

            <a href="#"
               class="panel_toggle_btn pull-right btn btn-sm  flat-btn m-l-10"
               data-panel-id="comments_box_{{ $review->id }}">
                <i class="fa fa-plus"></i> @lang('corals-directory-basic::labels.template.product_single.add_comments')
            </a>
            <a href="#"
               class="panel_toggle_btn pull-right btn btn-sm  flat-btn m-l-10"
               data-panel-id="review_comments_{{ $review->id }}">
                <i class="fa comment-o"></i> @lang('corals-directory-basic::labels.template.product_single.comments_count',['count'=>count($review->comments)])
            </a>
        @endif
        @auth
            <div class="pull-right">
                {!! $review->present('action') !!}

            </div>
        @endauth
        <div class="clearfix"></div>
    </div>
</div>
@if(user() && user()->can('Utility::comment.create'))
    <div class="row  m-10">
        <div class="col-md-12">
            <div class=" m-t-50" id="comments_box_{{ $review->id }}" style="min-height: 0px;display: none">

                <div class="row">
                    <div class="col-md-2">
                        <img src="{{  user()->picture_thumb }}"
                             alt="{{ user()->name }}"><br>
                    </div>
                    <div class="col-md-10">
                        <form class="custom-form ajax-form"
                              action="{{url('directory/user/'.$review->hashed_id.'/create-comment' )}}"
                              method="POST"
                              data-page_action="site_reload">
                            <div class="form-group required-field">
                        <textarea cols="10" rows="1"
                                  placeholder="@lang('corals-directory-basic::labels.template.product_single.add_comments')"
                                  name="body"
                                  style="height: 100px;"></textarea>
                            </div>

                            <button type="submit"
                                    class="btn small-btn color-bg flat-btn pull-right"
                                    style="margin: 0;">@lang('corals-directory-basic::labels.template.product_single.add_comment')
                                <i class="fa fa-paper-plane-o"
                                   aria-hidden="true"></i></button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="review_comments" id="review_comments_{{ $review->id }}" style="display: none">
    @if(count($review->comments))
        @foreach($review->comments as $comment)
            <div class="reviews-comments-item"
                 style="padding-bottom: 45px;">
                <div class="review-comments-avatar">
                    <img src="{{ $comment->author->picture_thumb }}"
                         alt="{{$comment->author->name}}"><br>
                </div>
                <div class="reviews-comments-item-text">

                    <div class="clearfix"></div>

                    <p>{{$comment->body}}</p>

                    <span class="reviews-comments-item-date">
                                <i class="fa fa-calendar-check-o"></i>
                        {{ $comment->created_at->diffForHumans() }}
                            </span>
                </div>
            </div>
        @endforeach
    @endif
</div>
