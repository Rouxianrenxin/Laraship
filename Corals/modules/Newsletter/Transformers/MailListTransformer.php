<?php

namespace Corals\Modules\Newsletter\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Newsletter\Models\MailList;

class MailListTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('newsletter.models.mail_list.resource_url');

        parent::__construct();
    }

    /**
     * @param MailList $mailList
     * @return array
     * @throws \Throwable
     */
    public function transform(MailList $mailList)
    {
        $show_url = url($this->resource_url . '/' . $mailList->hashed_id);

        return [
            'id' => $mailList->id,
            'name' => '<a href="' . $show_url . '">' . str_limit($mailList->name, 50) . '</a>',
            'status' => formatStatusAsLabels($mailList->status),
            'subscribers_count' => $mailList->subscribers_count ? '<a href="' . url($this->resource_url . "/$mailList->hashed_id/subscribers") . '"><i class="fa fa-id-card-o fa-fw"></i> ' . $mailList->subscribers_count . '</a>' : '-',
            'created_at' => format_date($mailList->created_at),
            'updated_at' => format_date($mailList->updated_at),
            'action' => $this->actions($mailList)
        ];
    }
}