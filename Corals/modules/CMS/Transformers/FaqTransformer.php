<?php

namespace Corals\Modules\CMS\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\CMS\Models\Faq;

class FaqTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('cms.models.faq.resource_url');

        parent::__construct();
    }

    /**
     * @param Faq $faq
     * @return array
     * @throws \Throwable
     */
    public function transform(Faq $faq)
    {
        return [
            'id' => $faq->id,
            'title' => str_limit($faq->title, 50),
            'published' => $faq->published ? '<i class="fa fa-check text-success"></i>' : '-',
            'published_at' => $faq->published ? format_date($faq->published_at) : '-',
            'categories' => formatArrayAsLabels($faq->categories->pluck('name'), 'success', '<i class="fa fa-folder-open"></i>'),
            'created_at' => format_date($faq->created_at),
            'updated_at' => format_date($faq->updated_at),
            'action' => $this->actions($faq)
        ];
    }
}
