<?php

namespace Corals\Modules\CMS\Models;

use Illuminate\Database\Eloquent\Builder;

class Page extends Content
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'page');
        });
    }

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'cms.models.page';

    protected $table = 'posts';


    protected $attributes = [
        'type' => 'page'
    ];

    protected $fillable = ['title', 'slug', 'meta_keywords', 'translation_language_code',
        'meta_description', 'content', 'published', 'published_at', 'private', 'internal', 'type', 'author_id', 'template', 'featured_image_link'];
}
