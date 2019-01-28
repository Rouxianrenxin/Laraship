<?php
/**
 * Created by PhpStorm.
 * User: ahmet
 * Date: 7/16/2018
 * Time: 12:24 PM
 */

namespace Corals\Modules\Directory\Http\Controllers;

use Corals\Modules\Directory\DataTables\ListingsDataTable;
use Corals\Modules\Directory\Http\Requests\ListingRequest;



class UserListingController extends ListingsController
{
    public function __construct()
    {
        $this->excludedRequestParams = array_merge($this->excludedRequestParams, [
            'verified', 'is_featured'
        ]);

        parent::__construct();
    }

    public function setVariables()
    {
        $this->resource_url = config('directory.models.listing.user_resource_url');
        $this->view_prefix = 'views.listings';
    }

    public function setTheme()
    {
        \Theme::set(\Settings::get('active_frontend_theme', config('themes.corals_frontend')));
    }

    public function index(ListingRequest $request, listingsDataTable $datatable)
    {

        return view($this->view_prefix . '.index');
    }

    public function getListingReviews()
    {
        return view($this->view_prefix . '.reviews');

    }
}