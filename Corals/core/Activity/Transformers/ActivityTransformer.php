<?php

namespace Corals\Activity\Transformers;

use Corals\Activity\Models\Activity;
use Corals\Foundation\Transformers\BaseTransformer;

class ActivityTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('activity.models.activity.resource_url');

        parent::__construct();
    }

    /**
     * @param Activity $activity
     * @return array
     * @throws \Throwable
     */
    public function transform(Activity $activity)
    {
        $actions = ['edit' => ''];
        $object_url = '#';
        if (class_exists($activity->subject_type) && $activity->subject_id) {
            $class = new $activity->subject_type();
            $config = config($class->config);
            if (array_has($config, 'resource_url')) {
                $object_url = url($config['resource_url'] . '/' . hashids_encode($activity->subject_id));
            }
        }

        return [
            'id' => $activity->id,
            'log_name' => $activity->log_name,
            'subject_type' => $activity->subject_type ? class_basename($activity->subject_type) : '-',
            'subject_id' => "<a target='_blank' href='{$object_url}'>{$activity->subject_id}</a>",
            'causer_id' => $activity->causer ? "<a target='_blank' href='" . url('users/' . $activity->causer->hashed_id) . "'> {$activity->causer->full_name }</a>" : '-',
            'description' => strlen($activity->description) > 70 ? generatePopover($activity->description) : $activity->description,
            'properties' => generatePopover($this->formatProperties($activity->properties)),
            'created_at' => format_date($activity->created_at),
            'updated_at' => format_date($activity->updated_at),
            'action' => $this->actions($activity, $actions)
        ];
    }

    protected function formatProperties($properties)
    {

        $formattedResponse = '';

        $this->appendDetails($formattedResponse, $properties);

        if (!empty($formattedResponse)) {
            $formattedResponse = '<table class="details-table">' . $formattedResponse . '</table>';
        }

        return $formattedResponse;
    }

    protected function appendDetails(&$formattedResponse, $detailsArray)
    {
        foreach ($detailsArray as $key => $value) {

            $keyTitle = str_replace('_', ' ', title_case($key));

            if (strlen($key) < 3) {
                $keyTitle = strtoupper($keyTitle);
            }

            if (is_array($value)) {
                $formattedResponse .= "<tr><td colspan='2'>{$keyTitle}</td>";

                $this->appendDetails($formattedResponse, $value);
            } else {
                $formattedResponse .= "<tr><td>{$keyTitle}</td>";

                if (empty($value)) {
                    $value = '-';
                }

                $formattedResponse .= "<td><b>{$value}</b></td>";
            }
        }
    }
}