<div class="rating-stars">
    @for($i = 1 ; $i <= 5; $i++)
        <i class="icon-star {{ $rating >= $i ?  'filled' : '' }}"></i>
    @endfor
</div>
@if($rating_count)
    <span class="text-muted align-middle">&nbsp;@lang('corals-marketplace-master::labels.partial.component.customer_review',['rating' => $rating ,'count' => $rating_count ])</span>
@endif