@extends('layouts.theme')

@section('title', $title_singular)

@section('css')
    {!! Theme::css('css/color-switcher.css') !!}
    {!! Theme::css('css/summernote.css') !!}
@stop


@section('editable_content')
    <div class="content">
        <section id="sec1">
            <div class="container">
                <div class="profile-edit-wrap">
                    <div class="row">
                        <div class="col-md-3">
                            @include('partials.dashboard_sidebar')
                        </div>
                        <div class="col-md-9">
                            <div class="profile-edit-container add-list-container">
                                <div class="custom-form">
                                    @if($listing->exists)
                                        <div class="row m-b-10">
                                            <div class="col-md-12">
                                                @component('components.box')
                                                    @include('Utility::gallery.gallery',['galleryModel'=>$listing,'editable'=>true])
                                                @endcomponent
                                            </div>
                                        </div>
                                    @endif
                                    @component('components.box')
                                        {!! Form::model($listing, ['url' => url($resource_url.'/'.$listing->hashed_id),'method'=>$listing->exists?'PUT':'POST','files'=>true,'class'=>'ajax-form']) !!}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><i class="fa fa-font"></i> </label>
                                                {!! CoralsForm::text('name','Directory::attributes.listing.name',true,$listing->name,[]) !!}
                                            </div>
                                            <div class="col-md-6">
                                                <label><i class="fa fa-link"></i> </label>

                                                {!! CoralsForm::text('slug','Directory::attributes.listing.slug',false, $listing->slug, ['help_text'=>'Directory::attributes.listing.slug_help','class' => '']) !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label><i class="fa  fa-commenting"></i> </label>

                                                {!! CoralsForm::text('caption','Directory::attributes.listing.caption',true,$listing->caption) !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><i class="fa  fa-th"></i> </label>

                                                {!! CoralsForm::select('categories[]','Directory::attributes.listing.categories', \Category::getCategoriesList('Directory'),true,null,['id'=>'categories','class' => '', 'multiple'=>true], 'select2') !!}
                                                <div id="attributes">
                                                </div>
                                            </div>
                                            <div class="col-md-6 label-width radio-inline">
                                                @can('admin', $listing)

                                                    {!! CoralsForm::radio('status','Corals::attributes.status',true, trans('Directory::attributes.listing.status_options'),null,['class'=>'radio inline']) !!}

                                                    @endif
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-8">
                                                @can('admin', $listing)
                                                    <label><i class="fa fa-users"></i> </label>

                                                    {!! CoralsForm::select('user_id','Directory::attributes.listing.owner', [], false, null,
                                                         ['class'=>'select2-ajax','data'=>[
                                                         'model'=>\Corals\User\Models\User::class,
                                                         'columns'=> json_encode(['name', 'email']),
                                                         'selected'=>json_encode($listing->user_id ? [$listing->user_id] :[]),
                                                         'where'=>json_encode([]),
                                                         ]],'select2')
                                                    !!}
                                                    @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label><i class="fa fa-location-arrow"></i> </label>

                                                {!! CoralsForm::select('location_id','Directory::attributes.listing.location',  \Address::getLocationsList('Directory'), true, $listing->location_id ,[], 'select2') !!}
                                            </div>
                                            <div class="col-md-8">

                                                <label><i class="fa fa-map-marker"></i> </label>

                                                {!! CoralsForm::text('address','Utility::attributes.location.address', true,null,['id'=>'_autocomplete','placeholder'=>'Utility::attributes.location.address_placeholder']) !!}
                                                <input type="hidden" name="lat" id="lat">
                                                <input type="hidden" name="long" id="long">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label><i class="fa  fa-link"></i> </label>

                                                {!! CoralsForm::text('website','Directory::attributes.listing.website',true) !!}
                                            </div>
                                            <div class="col-md-4">
                                                <label><i class="fa  fa-facebook"></i> </label>

                                                {!! CoralsForm::text('properties[social][facebook]','Directory::attributes.listing.facebook') !!}
                                            </div>
                                            <div class="col-md-4">
                                                <label><i class="fa  fa-twitter"></i> </label>

                                                {!! CoralsForm::text('properties[social][twitter]','Directory::attributes.listing.twitter') !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            @foreach(\Settings::get('contact_info',[]) as $key=>$value)
                                                <div class="col-md-4">
                                                    <label><i class="fa  fa-{{$key}}"></i> </label>

                                                    {!! CoralsForm::text('properties[contact_info]['.$key.']',$value) !!}
                                                </div>
                                            @endforeach

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label><i class="fa  fa-tags"></i> </label>

                                                {!! CoralsForm::select('tags[]','Directory::attributes.listing.tags', \Tag::getTagsList('Directory'),false,null,['class'=>'tags', 'multiple'=>true], 'select2') !!}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="custom-form">
                                                    {!! CoralsForm::textarea('description','Directory::attributes.listing.description',false, $listing->description, ['class'=>'ckeditor','rows'=>5]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th></th>
                                                            @foreach(\Settings::get('utility_days_of_the_week',[]) as $key=>$day)
                                                                <th>{{ $day }}</th>
                                                            @endforeach
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td class="required-field"><label>Start</label></td>
                                                            @foreach(\Settings::get('utility_days_of_the_week',[]) as $key=>$day)
                                                                <td>
                                                                    {!! CoralsForm::select("schedule[$key][start]", '', \Settings::get('utility_schedule_time',[]), false, $directory_schedules[$key]['start']) !!}
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        <tr>
                                                            <td class="required-field"><label>End</label></td>
                                                            @foreach(\Settings::get('utility_days_of_the_week',[]) as $key=>$day)
                                                                <td>
                                                                    {!! CoralsForm::select("schedule[$key][end]", '', \Settings::get('utility_schedule_time',[]), false, $directory_schedules[$key]['end']) !!}
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        {!! \Actions::do_action('directory_listing_form_post_fields', $listing) !!}
                                        {!! CoralsForm::customFields($listing) !!}

                                        <div class="row">
                                            <div class="col-md-12">
                                                {!! CoralsForm::formButtons() !!}
                                            </div>
                                        </div>


                                        {!! Form::close() !!}
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--container end -->

    <!-- section end -->
    <div class="limit-box fl-wrap"></div>

@endsection


@section('js')
    @include('Utility::category.category_scripts', ['product'=>$listing,'category_field_id'=>'#categories','attributes_div'=>'#attributes'])
    <script>
        var autocomplete;

        function initAutocomplete() {
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('_autocomplete')),
                {
                    types: ['geocode'],
                });
            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();
            $('#lat').val(place.geometry.location.lat());
            $('#long').val(place.geometry.location.lng());
        }

        var googleSrc = 'https://maps.googleapis.com/maps/api/js?key={{ \Settings::get('utility_google_address_api_key') }}&libraries=places&callback=initAutocomplete';
        document.write('<script src="' + googleSrc + '" async defer><\/script>');
    </script>
@endsection
