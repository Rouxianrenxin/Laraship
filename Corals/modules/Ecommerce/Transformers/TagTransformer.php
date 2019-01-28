<?php

namespace Corals\Modules\Ecommerce\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Ecommerce\Models\Tag;

class TagTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('ecommerce.models.tag.resource_url');

        parent::__construct();
    }

    /**
     * @param Tag $tag
     * @return array
     * @throws \Throwable
     */
    public function transform(Tag $tag)
    {
        return [
            'id' => $tag->id,
            'name' => str_limit($tag->name, 50),
            'slug' => $tag->slug,
            'products_count' => $tag->products_count,
            'status' => formatStatusAsLabels($tag->status),
            'created_at' => format_date($tag->created_at),
            'updated_at' => format_date($tag->updated_at),
            'action' => $this->actions($tag)
        ];
    }
}