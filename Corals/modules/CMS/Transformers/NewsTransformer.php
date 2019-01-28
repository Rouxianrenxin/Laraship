<?php
/**
 * Created by PhpStorm.
 * User: iMak
 * Date: 11/19/17
 * Time: 8:51 AM
 */

namespace Corals\Modules\CMS\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\CMS\Models\News;

class NewsTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('cms.models.news.resource_url');

        parent::__construct();
    }

    /**
     * @param News $news
     * @return array
     * @throws \Throwable
     */
    public function transform(News $news)
    {
        return [
            'id' => $news->id,
            'title' => str_limit($news->title, 50),
            'slug' => ($news->internal ? 'cms/' : '') . $news->slug,
            'published' => $news->published ? '<i class="fa fa-check text-success"></i>' : '-',
            'published_at' => $news->published ? format_date($news->published_at) : '-',
            'private' => $news->private ? '<i class="fa fa-check text-success"></i>' : '-',
            'internal' => $news->internal ? '<i class="fa fa-check text-success"></i>' : '-',
            'created_at' => format_date($news->created_at),
            'updated_at' => format_date($news->updated_at),
            'action' => $this->actions($news)
        ];
    }
}