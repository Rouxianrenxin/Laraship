<div class="stars-header-rating text-center">
    <div class="meta">
        <div class="icon-wrap">
            @for($i = 1 ; $i <= 5; $i++)
                <i class="lni-star{{ $rating >= $i ?  '-filled' : '' }}"></i>
            @endfor
        </div>
    </div>
    @if($rating_count)
        <div class="text-muted">
            <a href="#comments">@lang('corals-classified-master::labels.partial.component.customer_review',['rating' => $rating ,'count' => $rating_count ])</a>
        </div>
    @endif
</div>