<div class="reviews-comments-item">
    <div class="review-comments-avatar">
        <img src="{{ $review->author->picture_thumb }}"
             alt="{{$review->author->name}}"><br>
    </div>
    <div class="reviews-comments-item-text">
        @if ($show_status)
            <div class="pull-right">{!! $review->present('status') !!}</div>
        @endif
        <h4>{{$review->title}} {!!   $show_name ? ' - <a class="reviews-comments-item-link" target="_blank" href="'.$review->reviewrateable->getShowURL().'">'.  $review->reviewrateable->getIdentifier() .'</a> ': ''  !!}</h4>
        <div>
            @include('partials.components.rating',['rating'=> $review->rating,'rating_count'=>null ])
        </div>
        <div class="clearfix"></div>
        <p>{{$review->body}}</p>
        <span class="reviews-comments-item-date">
                                                    <i class="fa fa-calendar-check-o"></i>
            {{$review->created_at->diffForHumans()}}
                                                </span>
    </div>

        @include('partials.components.review_comments',['review'=> $review])

</div>