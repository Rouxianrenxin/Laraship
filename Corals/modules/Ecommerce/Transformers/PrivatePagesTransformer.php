<?php

namespace Corals\Modules\Ecommerce\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\CMS\Models\Content;
use Corals\Modules\Ecommerce\Models\Order;

class PrivatePagesTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('ecommerce.models.order.resource_url');

        parent::__construct();
    }

    /**
     * @param $postable
     * @return array
     * @throws \Throwable
     */
    public function transform($postable)
    {

        $order = $postable->sourcable_type == Order::class ? Order::find($postable->sourcable_id) : null;
        $post = Content::find($postable->content_id);
        $actions = ['edit' => '', 'delete' => ''];
        return [
            'id' => $postable->id,
            'order_number' => $order ? $order->present('order_number') : ' -',
            'page_link' => "<a target='_blank' href='" . url($post->slug) . "'>" . $post->title . "</a>",
        ];
    }
}