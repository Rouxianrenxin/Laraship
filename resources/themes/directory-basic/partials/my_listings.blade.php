@php
    $listings = \Corals\Modules\Directory\Facades\Directory::getListingsList(false,null,user()->id,true);
@endphp
<div class="dashboard-list-box fl-wrap">
    <div class="dashboard-header fl-wrap">
        <h3>@lang('corals-directory-basic::labels.dashboard.my_listings')</h3>
    </div>
    @forelse( $listings as $listing)
        <div class="dashboard-list" id="{{'row_'.$listing->hashed_id}}">
            <div class="dashboard-message">
                <span class="new-dashboard-item">{!! $listing->present('status') !!}</span>

                <div class="dashboard-listing-table-image">
                    <a target="_blank" href="{{$listing->getShowURL()}}"><img src="{{$listing->image}}" alt=""></a>
                </div>
                <div class="dashboard-listing-table-text">
                    <h4><a target="_blank" href="{{$listing->getShowURL()}}">{{$listing->name}}</a></h4>
                    <span class="dashboard-listing-table-address"><i
                                class="fa fa-map-marker"></i><a
                                href="#">{{$listing->address??$listing->location->address}}</a></span>
                    <div class="card-popup-rainingvis fl-wrap">
                        @if(\Settings::get('directory_rating_enable',true))
                            @include('partials.components.rating',['rating'=> $listing->averageRating(1)[0],'rating_count'=>$listing->countRating()[0] ])
                        @endif
                    </div>
                    <ul class="dashboard-listing-table-opt  fl-wrap">
                        <li>
                            <a href="{{url('directory/user/listings/'.$listing->hashed_id.'/edit')}}">@lang('corals-directory-basic::labels.dashboard.edit')
                                <i
                                        class="fa fa-pencil-square-o"></i></a></li>
                        <li><a href="{{url('directory/user/listings/'.$listing->hashed_id)}}" data-action="delete"
                               data-page_action="removeRow" data-action_data="{{ $listing->hashed_id }}"
                               class="del-btn">@lang('corals-directory-basic::labels.dashboard.delete') <i
                                        class="fa fa-trash-o"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info alert-dismissible fade show text-center margin-bottom-1x"><span
                    class="alert-close"
                    data-dismiss="alert"></span><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
            @lang('corals-directory-basic::labels.dashboard.sry_nothing_to_show')
        </div>
    @endforelse
</div>

{!! $listings->links('partials.paginator') !!}

<script type="text/javascript">
    function removeRow(response, $form, hashedId) {
        $("#row_" + hashedId).fadeOut();
    }
</script>