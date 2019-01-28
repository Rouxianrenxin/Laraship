@extends('layouts.crud.create_edit')

@section('css')
@endsection

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('address_location_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    @component('components.box')
        {!! CoralsForm::openForm($location) !!}
        <div class="row">
            <div class="col-md-4">
                {!! CoralsForm::text('name','Utility::attributes.location.name',true) !!}
                {!! CoralsForm::text('slug','Utility::attributes.location.slug',false, $location->slug, ['help_text'=>'Utility::attributes.location.slug_help']) !!}
                {!! CoralsForm::text('address','Utility::attributes.location.address', true,null,['onFocus'=>'geolocate()','id'=>'_autocomplete','placeholder'=>'Utility::attributes.location.address_placeholder']) !!}
                {!! CoralsForm::text('lat','Utility::attributes.location.lat',true) !!}
                {!! CoralsForm::text('long','Utility::attributes.location.long',true) !!}
            </div>
            <div class="col-md-4">
                {!! CoralsForm::text('zip','Utility::attributes.location.zip', false, null,['id'=>'_postal_code']) !!}
                {!! CoralsForm::text('city','Utility::attributes.location.city', false, null,['id'=>'_locality']) !!}
                {!! CoralsForm::text('state','Utility::attributes.location.state', false, null,['id'=>'_administrative_area_level_1']) !!}
                {!! CoralsForm::text('country','Utility::attributes.location.country', false, null,['id'=>'_country']) !!}
            </div>
            <div class="col-md-4">
                {!! CoralsForm::select('module','Utility::attributes.tag.module', \Utility::getUtilityModules()) !!}
                {!! CoralsForm::radio('status','Corals::attributes.status', true, trans('Corals::attributes.status_options')) !!}
                {!! CoralsForm::textarea('description','Utility::attributes.location.description') !!}
                {!! CoralsForm::customFields($location, 'col-md-12') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! CoralsForm::formButtons() !!}
            </div>
        </div>
        {!! CoralsForm::closeForm($location) !!}
    @endcomponent

    @component('components.box')
        <div id="map" style="height: 500px;">
        </div>
    @endcomponent
@endsection

@section('js')
    <script>
        var placeSearch, autocomplete;
        var componentForm = {
            _locality: 'long_name',
            _administrative_area_level_1: 'long_name',
            _country: 'long_name',
            _postal_code: 'short_name'
        };

        function initAutocomplete() {
            initMap();
            // Create the autocomplete object, restricting the search to geographical
            // location types.
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

            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            document.getElementById('lat').value = place.geometry.location.lat();
            document.getElementById('long').value = place.geometry.location.lng();

            // Get each component of the address from the place details
            // and fill the corresponding field on the form.
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm["_" + addressType]) {
                    var val = place.address_components[i][componentForm["_" + addressType]];
                    if (addressType === 'administrative_area_level_1') {
                        $("#_" + "administrative_area_level_1").val(val).trigger("change");
                    } else {
                        document.getElementById("_" + addressType).value = val;
                    }
                }
            }

            initMap();
        }

        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }

        var googleSrc = 'https://maps.googleapis.com/maps/api/js?key={{ \Settings::get('utility_google_address_api_key') }}&libraries=places&callback=initAutocomplete';

        document.write('<script src="' + googleSrc + '" async defer><\/script>');

        function stopEnterKey(event) {
            if ((event.keyCode === 13)) {
                return false;
            }
        }

        function initMap() {
            var lat = parseFloat(document.getElementById('lat').value);
            var long = parseFloat(document.getElementById('long').value);

            if (isNaN(lat) || isNaN(long)) {
                return;
            }

            var latLng = {lat: lat, lng: long};

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: latLng
            });

            var marker = new google.maps.Marker({
                position: latLng,
                map: map,
            });
        }

        $(document).ready(function () {
            document.onkeypress = stopEnterKey;
        });
    </script>
@endsection