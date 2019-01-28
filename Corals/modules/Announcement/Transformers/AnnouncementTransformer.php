<?php

namespace Corals\Modules\Announcement\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Announcement\Models\Announcement;

class AnnouncementTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('announcement.models.announcement.resource_url');

        parent::__construct();
    }

    /**
     * @param Announcement $announcement
     * @return array
     * @throws \Throwable
     */
    public function transform(Announcement $announcement)
    {
        return [
            'id' => $announcement->id,
            'title' => '<a href="' . $announcement->getShowURL() . '" class="show_announcement" data-title="' . $announcement->title . '">' . $announcement->title . '</a>',
            'content' => $announcement->content,
            'starts_at' => format_date($announcement->starts_at),
            'ends_at' => format_date($announcement->ends_at),
            'is_public' => $announcement->is_public ? '<i class="fa fa-check text-success"></i>' : '-',
            'show_immediately' => $announcement->show_immediately ? '<i class="fa fa-check text-success"></i>' : '-',
            'show_in_url' => $announcement->show_in_url,
            'created_at' => format_date($announcement->created_at),
            'updated_at' => format_date($announcement->updated_at),
            'action' => $this->actions($announcement)
        ];
    }
}