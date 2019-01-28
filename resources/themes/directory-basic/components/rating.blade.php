<div class="rating-stars">
    @for($i = 1 ; $i <= 5; $i++)
        <i class="fa fa-star {{ $rating >= $i ?  'filled' : '' }}"></i>
    @endfor
</div>
@if($rating_count)
    <span class="text-muted align-middle"> @lang('corals-directory-basic::labels.partial.component.customer_review',['name' => $rating ,'count' => $rating_count ])</span>

@endif