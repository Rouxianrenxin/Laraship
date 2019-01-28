<div class="listing-rating card-popup-rainingvis">
    @for($i = 1 ; $i <= 5; $i++)
        <i class="fa fa-star{{ $rating >= $i ?  '' : '-o' }}"></i>
    @endfor
    @if($rating_count)
        <span class="text-muted align-middle rating-count-text">&nbsp;@lang('corals-directory-basic::labels.partial.component.customer_review',['name' => $rating ,'count' => $rating_count ])</span>
    @endif
</div>
