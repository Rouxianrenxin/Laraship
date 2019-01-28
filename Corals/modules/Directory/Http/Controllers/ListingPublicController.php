<?php

namespace Corals\Modules\Directory\Http\Controllers;

use Corals\Modules\Directory\Facades\Directory;
use Corals\Modules\Directory\Models\Listing;
use Corals\Modules\CMS\Traits\SEOTools;
use Corals\Foundation\Http\Controllers\PublicBaseController;
use Corals\Modules\Utility\Classes\Schedule\ScheduleManager;
use Illuminate\Http\Request;
use Corals\Modules\Directory\DataTables\ListingsDataTable;
use Corals\Modules\Directory\Http\Requests\ListingRequest;
use Illuminate\Support\Facades\Mail;

class ListingPublicController extends PublicBaseController
{
    use SEOTools;

    public function __construct()
    {
        $this->resource_url = config('directory.models.listing.resource_url');

        $this->title = 'Directory::module.listing.title';
        $this->title_singular = 'Directory::module.listing.title_singular';

        parent::__construct();
    }


    public function show(Request $request, $slug)
    {
        $listing = Listing::where('slug', $slug)->first();
        if (!$listing) {
            abort('404');
        }
        $item = [
            'title' => $listing->name,
            'meta_description' => 'Directory Listing',
            'url' => url('listings/' . $listing->slug),
            'type' => 'listing',
            'image' => \Settings::get('site_logo'),
            'meta_keywords' => 'directory,listings'
        ];

        $schduleManager = new ScheduleManager($listing);

        $schdule = $schduleManager->getSchedule();

        $this->setSEO((object)$item);

        $listing->visitors_count += 1;

        $listing->update();

        \JavaScript::put([
            'marker_icon_url' => \Theme::url('images/marker.png')
        ]);

        return view('templates.listing_single', compact('listing', 'schdule'));
    }


    public function index(Request $request)
    {
        $item = [
            'title' => 'Listings',
            'meta_description' => 'Directory Listing',
            'url' => url('listings'),
            'type' => 'listing',
            'image' => \Settings::get('site_logo'),
            'meta_keywords' => 'directory,listings'
        ];

        $this->setSEO((object)$item);


        $listings = Directory::getListings($request->all());

        $sortOptions = trans(config('directory.models.listing.sort_options'));

        if (\Settings::get('directory_rating_enable') == "true") {
            $sortOptions['average_rating'] = trans('Directory::attributes.listing.average_rating');
        }

        $locationData = [];


        $counter = 1;
        foreach ($listings as $listing) {
            $categories = [];
            foreach ($listing->categories as $category) {
                array_push($categories, $category->name);
            }
            array_push($locationData,
                [
                    $this->locationData(url('listings/' . $listing->slug), $categories, $listing->image, $listing->name, $listing->address, $listing->getProperty('contact_info.phone_number'), $listing->averageRating(1)[0]),
                    $listing->lat ?? $listing->location->lat,
                    $listing->long ?? $listing->location->long,
                    $counter++
                ]
            );
        }

        \JavaScript::put([
            'map_locations' => $locationData,
            'marker_icon_url' => \Theme::url('images/marker.png')
        ]);

        return view('templates.listings')->with(compact('listings', 'sortOptions'));
    }

    protected function locationData($locationURL = null, $locationCategory = null, $locationImg = null, $locationTitle = null, $locationAddress = null, $locationPhone = null, $locationStarRating = 0)
    {
        return HtmlElement('div.map-popup-wrap > div.map-popup', [
            HtmlElement('div.infoBox-close > i.fa fa-times'),
            HtmlElement('div.map-popup-category', [], $locationCategory),
            HtmlElement('a.listing-img-content fl-wrap[href="' . $locationURL . '"]',
                [
                    htmlElement('img[src=' . $locationImg . ']')]), htmlElement('div.listing-content fl-wrap',
                [
                    HtmlElement('div.card-popup-raining map-card-rainting[data-staRrating =' . $locationStarRating . ']', [HtmlElement('span.map-popup-reviews-count', [], $locationTitle)]),
                    HtmlElement('div.listing-title fl-wrap',
                        [
                            HtmlElement('h4 > a[href="' . $locationURL . '"]', [], $locationTitle),
                            HtmlElement('span.map-popup-location-info', [
                                HtmlElement('i.fa fa-map-marker'),
                                HtmlElement('span', [], $locationAddress)
                            ]),
                            HtmlElement('span.map-popup-location-phone', [HtmlElement('i.fa fa-phone'), HtmlElement('span', [], $locationPhone)])
                        ]
                    )
                ])
        ]);

    }

    public function contact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'listing_email' => 'required|email',
            'message' => 'required'
        ]);

        $data = $request->all();

        Mail::send('emails.contact', $data, function ($message) {
            $message->from(\Request::get('email'), 'Contact message for: ' . \Request::get('listing_name'));
            $message->to(\Request::get('listing_email'));
        });

        return \Response::json(['message' => trans('CMS::labels.message.email_sent_success'), 'class' => 'alert-success', 'level' => 'success']);
    }


}