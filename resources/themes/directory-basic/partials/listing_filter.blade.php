<form id="listing_form">
    <div class="listsearch-input-wrap fl-wrap">
        <div class="listsearch-input-item">
            <i class="mbri-key single-i"></i>
            <input type="text" placeholder="@lang('corals-directory-basic::labels.template.listing.keywords'):"
                   name="search"
                   value="{{request()->get('search')}}"/>
        </div>
        <div class="listsearch-input-item">
            <select data-placeholder="Location" name="location"
                    onchange="showListingLocationOption()">
                <option value="">@lang('corals-directory-basic::labels.template.listing.location')</option>
                @foreach(\Address::getLocationsList('Directory',true) as $location)
                    <option value="{{$location->slug}}" {{  checkActiveKey($location->slug,'location') ? "selected" : ""  }}>{{$location->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="listsearch-input-item">
            <select data-placeholder="All Categories" name="category">
                <option value=""
                        selected>@lang('corals-directory-basic::labels.template.listing.all_categories')</option>
                @foreach(\Category::getCategoriesList('Directory',false,true) as $category)
                    <option value="{{$category->slug}}" {{  checkActiveKey($category->slug,'category')?'selected':'' }}>{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="listsearch-input-text" id="autocomplete-container">
        </div>
        <!-- hidden-listing-filter -->
        <div class="hidden-listing-filter fl-wrap">
            <div class=" fl-wrap filter-tags">
                <div class="filter-tags-wrap">
                    <h4>Filter by</h4>
                    <input id="check-a" type="checkbox" name="open"
                           value="open" {{  checkActiveKey('open','open')?'checked':'' }}>
                    <label for="check-a">@lang('corals-directory-basic::labels.template.listing.open_only')</label>
                </div>
            </div>
            <div class="distance-input fl-wrap">
                <div class="distance-title"> @lang('corals-directory-basic::labels.template.listing.radius_around_selected_destination')
                    <span></span> @lang('corals-directory-basic::labels.template.listing.km')
                </div>
                <div class="distance-radius-wrap fl-wrap">
                    <input class="distance-radius rangeslider--horizontal" type="range" min="0"
                           max="100" step="1"
                           value="{{request()->has('distance')?request()->get('distance'):0}}"
                           data-title="Radius around selected destination" name="distance">
                </div>
                <input type="hidden" name="lat" id="lat" value="{{request()->get('lat')}}">
                <input type="hidden" name="long" id="long" value="{{request()->get('long')}}">
                <div class=" fl-wrap filter-tags">
                    <div class="filter-tags-wrap">

                        <input type="radio" value="current_location" name="location_coordinates"
                               onclick="getLocation()" {{  checkActiveKey('current_location','location_coordinates')?'checked':'' }}>
                        <label>@lang('corals-directory-basic::labels.template.listing.using_current_location_as_reference')</label>
                    </div>
                    <div class="filter-tags-wrap {{  checkActiveKey('listing_location','location_coordinates')||request()->has('location') ?'':'display-none' }}">
                        <input type="radio" value="listing_location"
                               name="location_coordinates"

                                {{  checkActiveKey('listing_location','location_coordinates')?'checked':'' }}>
                        <label>@lang('corals-directory-basic::labels.template.listing.using_listing_location_as_reference')</label>
                    </div>
                </div>
            </div>
            <!-- Checkboxes -->
            <div class=" fl-wrap filter-tags">
                <h4>@lang('corals-directory-basic::labels.template.listing.filter_by_tags')</h4>
                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::select('tags[]','', \Tag::getTagsList('Directory'),false,null,['class'=>'tags', 'multiple'=>true], 'select2') !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- hidden-listing-filter end -->
        <button class="button fs-map-btn"
                type="submit">@lang('corals-directory-basic::labels.template.listing.filter')</button>
        <button class="button fs-map-btn"
                type="button" style="margin-left: 10px;"
                onclick="clearForm(null, $('#listing_form'))">@lang('corals-directory-basic::labels.template.listing.clear_filter')</button>
        <div class="more-filter-option">@lang('corals-directory-basic::labels.template.listing.more_filter')
            <span></span></div>
    </div>
    <!-- listsearch-input-wrap end -->
    </div>
    </div>
</form>