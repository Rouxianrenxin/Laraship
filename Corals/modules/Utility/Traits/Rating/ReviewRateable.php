<?php

namespace Corals\Modules\Utility\Traits\Rating;

use Corals\Modules\Utility\Models\Rating\Rating;
use Illuminate\Database\Eloquent\Model;

trait ReviewRateable
{
    public static function bootReviewRateable()
    {
        static::deleted(function (Model $deletedModel) {
            if (schemaHasTable('utility_ratings')) {
                $deletedModel->ratings()->delete();
            }
        });
    }

    /**
     * @param null $status
     * @return mixed
     */
    public function ratings($status = null)
    {
        $ratings = $this->morphMany(Rating::class, 'reviewrateable');

        if (!is_null($status)) {
            $ratings = $ratings->where('utility_ratings.status', $status);
        }

        return $ratings;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function author()
    {
        return $this->morphTo('author');
    }

    /**
     * @param null $round
     * @param bool $criteria
     * @return \Illuminate\Support\Collection
     */
    public function averageRating($round = null, $criteria = false)
    {
        $ratings = $this->ratings('approved');

        if ($criteria !== false) {
            $ratings = $ratings->where('criteria', $criteria);
        }

        if ($round) {
            $ratings = $ratings->selectRaw('ROUND(AVG(rating), ' . $round . ') as averageReviewRateable');
        } else {
            $ratings = $ratings->selectRaw('AVG(rating) as averageReviewRateable');
        }

        return $ratings->pluck('averageReviewRateable');
    }

    /**
     * @param bool $criteria
     * @return \Illuminate\Support\Collection
     */
    public function countRating($criteria = false)
    {
        $ratings = $this->ratings('approved');

        if ($criteria !== false) {
            $ratings = $ratings->where('criteria', $criteria);
        }

        return $ratings->selectRaw('count(rating) as countReviewRateable')
            ->pluck('countReviewRateable');
    }

    /**
     * @param bool $criteria
     * @return \Illuminate\Support\Collection
     */
    public function sumRating($criteria = false)
    {
        $ratings = $this->ratings('approved');

        if ($criteria !== false) {
            $ratings = $ratings->where('criteria', $criteria);
        }

        return $ratings->selectRaw('SUM(rating) as sumReviewRateable')
            ->pluck('sumReviewRateable');
    }

    /**
     * @param int $max
     * @return float|int
     */
    public function ratingPercent($max = 5)
    {
        $ratings = $this->ratings('approved');
        $quantity = $ratings->count();
        $total = $ratings->selectRaw('SUM(rating) as total')->pluck('total');
        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }

    /**
     * @param bool $criteria
     * @param null $user
     * @return mixed
     */
    public function getRating($criteria = false, $user = null)
    {
        $ratings = $this->ratings('approved');

        $ratings = $ratings->select('rating');

        if ($criteria !== false) {
            $ratings = $ratings->where('criteria', $criteria);
        }

        if (is_null($user)) {
            $user = user();
        }

        $ratings = $ratings
            ->where('author_id', $user->id)
            ->where('author_type', get_class($user));

        $ratings = $ratings->first();

        return $ratings['rating'];
    }
}
