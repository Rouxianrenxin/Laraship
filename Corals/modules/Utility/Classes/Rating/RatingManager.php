<?php

namespace Corals\Modules\Utility\Classes\Rating;


use Illuminate\Database\Eloquent\Model;
use Corals\Modules\Utility\Models\Rating\Rating as RatingModel;

class RatingManager
{

    protected $instance, $author;

    /**
     * RatingManager constructor.
     * @param $instance
     * @param $author
     */
    public function __construct($instance = null, $author = null)
    {
        $this->instance = $instance;
        $this->author = $author;
    }

    /**
     * @param $data
     * @return RatingModel|Model
     */
    public function createRating($data)
    {
        $data = array_merge([
            'reviewrateable_id' => $this->instance->id,
            'reviewrateable_type' => get_class($this->instance),
            'author_id' => $this->author->id,
            'author_type' => get_class($this->author),
        ], $data);

        $ratingModel = RatingModel::create($data);

        event('notifications.rate.rate_created', [
            'rating' => $ratingModel,
        ]);

        return $ratingModel;
    }

    /**
     * @param RatingModel $rating
     * @param $data
     * @return bool
     */
    public function updateRating(RatingModel $rating, $data)
    {
         $rating->update($data);
    }

    public function handleModelRating($data)
    {
        $rating = $this->instance->ratings()->where([
            'author_id' => $this->author->id,
            'author_type' => get_class($this->author),
            'criteria' => $data['criteria'] ?? null,
        ])->first();

        if ($rating) {
             $this->updateRating($rating, $data);
        } else {
            $setting_name = strtolower(class_basename($this->instance)) . '_default_rating_status';
            $data['status'] = \Settings::get($setting_name, 'approved');
            $rating = $this->createRating($data);
        }
        return $rating;
    }

    /**
     * @param RatingModel $rating
     * @return bool|null
     * @throws \Exception
     */
    public function deleteRating($rating)
    {
        return $rating->delete();
    }

    public function toggleStatus($rating, $status)
    {
        $update = $rating->update([
            'status' => $status,
        ]);

        event('notifications.rate.rate_toggle_status', [
            'rating' => $rating,
        ]);

        return $update;

    }

    public function drawStarts($count = 0)
    {

        $stars = '';

        for ($i = 1; $i <= 5; $i++) {
            $muted = $count >= $i ? "" : "-o";
            $stars .= '<i class="fa fa-star' . $muted . '"></i>';
        }

        return $stars;
    }
}
