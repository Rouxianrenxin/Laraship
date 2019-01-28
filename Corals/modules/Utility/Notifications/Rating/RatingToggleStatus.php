<?php

namespace Corals\Modules\Utility\Notifications\Rating;

use Corals\User\Communication\Classes\CoralsBaseNotification;

class RatingToggleStatus extends CoralsBaseNotification
{
    /**
     * @return mixed
     */
    public function getNotifiables()
    {
        $ratingModel = $this->data['rating'];

        $reviewrateable = $ratingModel->reviewrateable;

        $owner = method_exists($reviewrateable, 'owner') ? $reviewrateable->owner() : $reviewrateable->creator;

        if (!empty($owner)) {
            return $owner;
        } else {
            return [];
        }
    }

    public function getNotificationMessageParameters($notifiable, $channel)
    {
        $ratingModel = $this->data['rating'];

        $author = $ratingModel->author;

        $reviewrateable = $ratingModel->reviewrateable;

        $setting_name = strtolower(class_basename($reviewrateable)) . '_default_rating_status';

        $status = $ratingModel->status ? $ratingModel->status : \Settings::get($setting_name);

        return [
            'reviewrateable_identifier' => $reviewrateable->getIdentifier(),
            'reviewrateable_class' => class_basename($reviewrateable),
            'rating' => $ratingModel->rating,
            'rating_title' => $ratingModel->title ?? '-',
            'rating_body' => $ratingModel->body ?? '-',
            'rating_status' => $status,
            'rating_criteria' => $ratingModel->criteria ?? '-',
            'author_name' => $author->name,
            'author_email' => $author->email,
        ];
    }

    public static function getNotificationMessageParametersDescriptions()
    {
        return [
            'reviewrateable_identifier' => 'Reviewrateable identifier',
            'reviewrateable_class' => 'Reviewrateable class',
            'author_name' => 'Rating author name',
            'author_email' => 'Rating author email',
            'rating' => 'Rating value',
            'rating_title' => 'Rating title',
            'rating_body' => 'Rating Body',
            'rating_status' => 'Rating Status',
            'rating_criteria' => 'Rating Criteria',
        ];
    }
}
