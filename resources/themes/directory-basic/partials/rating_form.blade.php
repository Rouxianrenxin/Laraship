@if(!user())
    <div id="sec5" class="alert alert-info alert-dismissible fade show text-center margin-bottom-1x"
         style="margin-bottom: 40px;"><span
                class="alert-close"
                data-dismiss="alert"></span><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
        @lang('corals-directory-basic::labels.partial.tabs.need_login_review')
    </div>
@elseif(user()->hashed_id != optional($listing->owner())->hashed_id)
    @if(user()->can('Utility::rating.create'))
        <div class="list-single-main-item fl-wrap" id="sec5" style="margin-bottom: 40px;">
            <form class="add-comment custom-form ajax-form" autocomplete="off"
                  action="{{url('directory/user/'.$listing->hashed_id.'/rate' )}}"
                  method="POST" id="reviewForm" data-page_action="site_reload">

                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="list-single-main-item-title fl-wrap">
                    <h3>@lang('corals-directory-basic::labels.template.product_single.add_review')
                        & @lang('corals-directory-basic::labels.template.product_single.rate_listing')</h3>
                </div>
                <!-- Add Review Box -->
                <div id="add-review" class="add-review-box">
                    <div class="leave-rating-wrap">
                                                    <span class="leave-rating-title">@lang('corals-directory-basic::labels.template.product_single.your_rating_for_this_listing')
                                                        : </span>
                        <div class="leave-rating">
                            <input type="radio" name="review_rating" id="rating-1"
                                   value="5"/>
                            <label for="rating-1" class="fa fa-star-o"></label>
                            <input type="radio" name="review_rating" id="rating-2"
                                   value="4"/>
                            <label for="rating-2" class="fa fa-star-o"></label>
                            <input type="radio" name="review_rating" id="rating-3"
                                   value="3"/>
                            <label for="rating-3" class="fa fa-star-o"></label>
                            <input type="radio" name="review_rating" id="rating-4"
                                   value="2"/>
                            <label for="rating-4" class="fa fa-star-o"></label>
                            <input type="radio" name="review_rating" id="rating-5"
                                   value="1"/>
                            <label for="rating-5" class="fa fa-star-o"></label>
                        </div>
                    </div>
                    <!-- Review Comment -->

                    <fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label><i class="fa fa-text-width"></i></label>
                                    <input type="text"
                                           placeholder="@lang('corals-directory-basic::labels.template.product_single.subject') *"
                                           name="review_subject"
                                           value=""/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">

                            <textarea cols="40" rows="3"
                                      placeholder="@lang('corals-directory-basic::labels.template.product_single.your_review'):"
                                      name="review_text"></textarea>
                        </div>
                    </fieldset>

                    <button type="submit"
                            class="btn  big-btn  color-bg flat-btn">@lang('corals-directory-basic::labels.template.product_single.submit_review')
                        <i
                                class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                </div>
            </form>
        </div>
        <!-- Add Review Box / End -->
    @endif
@else
    <div id="sec5" class="alert alert-info alert-dismissible fade show text-center margin-bottom-1x"
         style="margin-bottom: 40px;"><span
                class="alert-close"
                data-dismiss="alert"></span><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
        @lang('corals-directory-basic::labels.partial.tabs.owner_of_listing')
    </div>
@endif