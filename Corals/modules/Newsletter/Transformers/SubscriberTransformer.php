<?php

namespace Corals\Modules\Newsletter\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Newsletter\Models\Subscriber;

class SubscriberTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('newsletter.models.subscriber.resource_url');

        parent::__construct();
    }

    /**
     * @param Subscriber $subscriber
     * @return array
     * @throws \Throwable
     */
    public function transform(Subscriber $subscriber)
    {
        $show_url = url($this->resource_url . '/' . $subscriber->hashed_id);

        $mailLists = $subscriber->mailLists()->pluck('name')->toArray();

        return [
            'id' => $subscriber->id,
            'email' => '<a href="' . $show_url . '">' . $subscriber->email . '</a>',
            'name' => $subscriber->name ? '<a href="' . $show_url . '">' . str_limit($subscriber->name, 50) . '</a>' : '-',
            'status' => formatStatusAsLabels($subscriber->status),
            'mail_lists_count' => $subscriber->mail_lists_count ? generatePopover(formatArrayAsLabels($mailLists), $subscriber->mail_lists_count) : '-',
            'created_at' => format_date($subscriber->created_at),
            'updated_at' => format_date($subscriber->updated_at),
            'action' => $this->actions($subscriber)
        ];
    }
}