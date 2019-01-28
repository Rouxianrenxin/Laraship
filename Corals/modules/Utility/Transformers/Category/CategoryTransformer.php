<?php

namespace Corals\Modules\Utility\Transformers\Category;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\Utility\Models\Category\Category;

class CategoryTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('utility.models.category.resource_url');

        parent::__construct();
    }

    /**
     * @param Category $category
     * @return array
     * @throws \Throwable
     */
    public function transform(Category $category)
    {
        return [
            'id' => $category->id,
            'name' => $category->name . ($category->is_featured ? '&nbsp;<i class="fa fa-star text-warning" title="Featured"></i>' : ''),
            'slug' => $category->slug,
            'parent_id' => optional($category->parent)->name ?? '-',
            'status' => formatStatusAsLabels($category->status),
            'created_at' => format_date($category->created_at),
            'updated_at' => format_date($category->updated_at),
            'action' => $this->actions($category)
        ];
    }
}