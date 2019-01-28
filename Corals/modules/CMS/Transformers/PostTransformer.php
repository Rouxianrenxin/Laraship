<?php

namespace Corals\Modules\CMS\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Modules\CMS\Models\Post;

class PostTransformer extends BaseTransformer
{
    public function __construct()
    {
        $this->resource_url = config('cms.models.post.resource_url');

        parent::__construct();
    }

    /**
     * @param Post $post
     * @return array
     * @throws \Throwable
     */
    public function transform(Post $post)
    {
        $show_url = url($this->resource_url . '/' . $post->hashed_id);
        return [
            'id' => $post->id,
            'title' => '<a href="' . $show_url . '" target="_blank">' . str_limit($post->title, 50) . '</a>',
            'slug' => ($post->internal ? 'cms/' : '') . $post->slug,
            'published' => $post->published ? '<i class="fa fa-check text-success"></i>' : '-',
            'published_at' => $post->published ? format_date($post->published_at) : '-',
            'categories' => formatArrayAsLabels($post->categories->pluck('name'), 'success', '<i class="fa fa-folder-open"></i>'),
            'private' => $post->private ? '<i class="fa fa-check text-success"></i>' : '-',
            'internal' => $post->internal ? '<i class="fa fa-check text-success"></i>' : '-',
            'created_at' => format_date($post->created_at),
            'updated_at' => format_date($post->updated_at),
            'action' => $this->actions($post)
        ];
    }
}