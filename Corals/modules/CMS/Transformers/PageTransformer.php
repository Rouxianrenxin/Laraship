<?php

namespace Corals\Modules\CMS\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\CMS\Models\Page;

class PageTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('cms.models.page.resource_url');

        parent::__construct();
    }

    /**
     * @param Page $page
     * @return array
     * @throws \Throwable
     */
    public function transform(Page $page)
    {
        $show_url = url($this->resource_url . '/' . $page->hashed_id);
        return [
            'id' => $page->id,
            'title' => '<a href="' . $show_url . '" target="_blank">' . str_limit($page->title, 50) . '</a>',
            'slug' => ($page->internal ? 'cms/' : '') . $page->slug,
            'published' => $page->published ? '<i class="fa fa-check text-success"></i>' : '-',
            'published_at' => $page->published ? format_date($page->published_at) : '-',
            'private' => $page->private ? '<i class="fa fa-check text-success"></i>' : '-',
            'internal' => $page->internal ? '<i class="fa fa-check text-success"></i>' : '-',
            'created_at' => format_date($page->created_at),
            'updated_at' => format_date($page->updated_at),
            'action' => $this->actions($page, [
                'edit_in_designer' => [
                    'icon' => 'fa fa-paint-brush fa-fw',
                    'href' => url($this->resource_url . '/' . $page->hashed_id . '/design'),
                    'label' => trans('CMS::labels.page.edit_designer'),
                    'target' => '_blank',
                    'data' => []
                ],

            ])
        ];
    }
}