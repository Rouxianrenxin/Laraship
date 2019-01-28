<?php

namespace Corals\Modules\Directory\Classes;

use Corals\Modules\Directory\Models\Listing;
use Corals\Modules\Utility\Models\Address\Location;
use Corals\Modules\Utility\Models\Rating\Rating;
use Corals\Settings\Facades\Settings;
use Corals\Modules\Utility\Models\Category\Category;
use Corals\Foundation\Search\Search;
use Carbon\Carbon;
use Corals\User\Models\User;
use http\Env\Request;

class Directory
{
    public $page_limit;

    public function __construct()
    {
        $this->page_limit = Settings::get('directory_appearance_page_limit', 10);
    }

    public function getListings($filters = [])
    {
        $listings = $this->listingsPublicBaseQuery();

        foreach ($filters as $filter => $value) {
            $filterMethod = $filter . 'QueryBuilderFilter';
            if (method_exists($this, $filterMethod) && !empty($value)) {
                $listings = $this->{$filterMethod}($listings, $value);
            }
        }

        $listings = $listings->addSelect('directory_listings.*')->paginate($this->page_limit);

        return $listings;
    }

    protected function sortQueryBuilderFilter($listings, $sortOption)
    {
        switch ($sortOption) {
            case 'popular':
                break;
            case 'low_high_price':
                $listings = $listings->orderBy('price', 'asc');
                break;
            case 'high_low_price':
                $listings = $listings->orderBy('price', 'desc');
                break;
            case 'average_rating':
                $listings = $listings->leftJoin('ratings', 'reviewrateable_id', '=', 'directory_listings.id')
                    ->where('ratings.reviewrateable_type', Listing::class)
                    ->orWhereNull('ratings.id')
                    ->addSelect(\DB::raw('ROUND(AVG(rating), 2) as averageReviewRateable'))->orderBy('averageReviewRateable', 'desc');
                break;
            case 'a_z_order':
                $listings = $listings->orderBy('directory_listings.name', 'asc');
                break;
            case 'z_a_order':
                $listings = $listings->orderBy('directory_listings.name', 'desc');
                break;
        }
        return $listings;
    }

    protected function locationQueryBuilderFilter($listings, $location_slug)
    {
        $queryMethod = 'where';

        if (is_array($location_slug)) {
            $queryMethod = 'whereIn';
        }

        $listings = $listings->join('utility_locations', 'directory_listings.location_id', 'utility_locations.id')
            ->{$queryMethod}('utility_locations.slug', $location_slug);


        return $listings;
    }

    protected function searchQueryBuilderFilter($listings, $search_term)
    {

        $search = new Search();

        $config = [
            'title_weight' => \Settings::get('directory_search_title_weight'),
            'content_weight' => \Settings::get('directory_search_content_weight'),
            'enable_wildcards' => \Settings::get('directory_search_enable_wildcards')
        ];

        $listings = $search->AddSearchPart($listings, $search_term, Listing::class, $config);

        return $listings;
    }

    protected function categoryQueryBuilderFilter($listings, $category, $status = 'active')
    {
        $queryMethod = 'where';

        if (is_array($category)) {
            $queryMethod = 'whereIn';
        }

        $orQueryMethod = 'or' . ucfirst($queryMethod); // << i.e orWhere || orWhereIn

        $categories = Category::{$queryMethod}('utility_categories.id', $category)
            ->orWhere(function ($parent) use ($queryMethod, $category) {
                $parent->{$queryMethod}('utility_categories.parent_id', $category)
                    ->where('utility_categories.parent_id', '<>', 0);
            })->{$orQueryMethod}('utility_categories.slug', $category)->pluck('id')->toArray();

        $listings = $listings->join('utility_model_has_category', 'utility_model_has_category.model_id', 'directory_listings.id')
            ->join('utility_categories', 'utility_model_has_category.category_id', 'utility_categories.id')
            ->where('utility_model_has_category.model_type', Listing::class)
            ->where(function ($query) use ($categories) {
                $query->whereIn('utility_categories.id', $categories)
                    ->orWhereIn('utility_categories.parent_id', $categories);
            });

        if (!empty($status)) {
            $listings->where('directory_listings.status', $status);
        }

        return $listings;

    }

    protected function userQueryBuilderFilter($products, $user_hashed_id)
    {
        $user = User::findByHash($user_hashed_id);

        if (!$user) {
            abort(404);
        }

        $products = $products->where('directory_listings.user_id', $user->id);

        return $products;

    }


    protected function openQueryBuilderFilter($listings, $open)
    {
        if ($open != 'open') {
            return $listings;
        }

        $dayOfWeek = Carbon::now()->format('l');

        $today = substr($dayOfWeek, 0, 3);

        $currentTime = date('h:i:s');

        $listings = $listings->join('utility_schedules', 'utility_schedules.scheduleable_id', '=', 'directory_listings.id')
            ->where('utility_schedules.day_of_the_week', $today)
            ->where(function ($parent) use ($currentTime) {
                $parent->where('utility_schedules.start_time', '<=', $currentTime)
                    ->Where('utility_schedules.end_time', '>=', $currentTime);
            });

        return $listings;
    }

    protected function distanceQueryBuilderFilter($listings, $distance)
    {
        $location_coordinates = \Request::get('location_coordinates');

        if ($location_coordinates == 'current_location') {

            $lat = \Request::get('lat');

            $long = \Request::get('long');

        } else if ($location_coordinates == 'listing_location') {

            $location_slug = \Request::get('location');
            if ($location_slug) {
                $location = Location::query()->where('utility_locations.slug', $location_slug)->first();
                if ($location_slug) {
                    $lat = $location->lat;
                    $long = $location->long;
                }

            }


        }

        if (empty($lat) || empty($long)) {
            return $listings;
        }

        $listings = $this->calculateDistance($listings, $distance, $lat, $long);

        return $listings;
    }

    protected function calculateDistance($listings, $distance, $lat, $long)
    {
        $listings = $listings->CalculateDistanceFor($lat, $long, $distance);

        return $listings;

    }

    public function listingsPublicBaseQuery($all = false)
    {
        if ($all) {
            return Listing::groupBy('directory_listings.id');
        } else {
            return Listing::active()->groupBy('directory_listings.id');

        }
    }

    public function getListingsList($featured = false, $count = null, $user = null, $all = false)
    {
        $listings = $this->listingsPublicBaseQuery($all);

        if ($featured) {
            $listings = $listings->featured();
        }
        if ($count) {
            $listings = $listings->limit($count);
        }
        if ($user) {
            $listings = $listings->where('user_id', $user);
        }

        $listings = $listings->paginate($this->page_limit);

        return $listings;
    }

    public function getListingsReviews($user = null, $all = false)
    {

        $reviews = $user->listingReviews();

        $reviews = $reviews->paginate($this->page_limit);

        return $reviews;
    }


    public function getListingsCount($status, $user = null)
    {
        $listingsCount = Listing::query();

        if ($status) {
            $listingsCount = $listingsCount->where('status', $status);
        }
        if ($user) {
            $listingsCount = $listingsCount->where('user_id', $user);
        }

        return $listingsCount->count();
    }

    public function getListingsVisitorsCount($status, $user = null)
    {
        $visitorsCount = Listing::query();

        if ($status) {
            $visitorsCount = $visitorsCount->where('status', $status);
        }
        if ($user) {
            $visitorsCount = $visitorsCount->where('user_id', $user);
        }
        return $visitorsCount->sum('visitors_count');
    }

    public function getUserListingReviewsCount($user_id)
    {
        return Rating::query()->join('directory_listings', 'directory_listings.id', '=', 'utility_ratings.reviewrateable_id')
            ->where('directory_listings.user_id', $user_id)->count();

    }

    public function getCategoryListingsCount($cat_id)
    {
        return Category::query()->join('utility_model_has_category', 'utility_categories.id', '=', 'utility_model_has_category.category_id')
            ->where('utility_model_has_category.category_id', $cat_id)
            ->count();
    }


}