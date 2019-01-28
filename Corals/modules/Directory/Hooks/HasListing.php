<?php

namespace Corals\Modules\Directory\Hooks;


use Corals\Modules\Directory\Models\Listing;
use Corals\Modules\Utility\Models\Rating\Rating;

Class HasListing
{

    public function listings()
    {
        return function ($params = []) {

            $relation = $this->HasMany(Listing::class, 'user_id');

            if (isset($params['getData']) && $params['getData']) {
                return $relation->getResults();
            } else {
                return $relation;
            }
        };
    }


    public function listingReviews()
    {
        return function ($params = []) {

            $relation = $this->hasManyDeep(
                Rating::class,
                [Listing::class],
                ['user_id', ['reviewrateable_type', 'reviewrateable_id']]
            );


            if (isset($params['getData']) && $params['getData']) {
                return $relation->getResults();
            } else {
                return $relation;
            }
        };
    }


}
