<?php
/**
 * Created by PhpStorm.
 * User: iMak
 * Date: 11/19/17
 * Time: 8:41 AM
 */

namespace Corals\Modules\CMS\Models;

use Illuminate\Database\Eloquent\Builder;

class News extends Content
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'news');
        });
    }


    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'cms.models.news';

    protected $table = 'posts';

    protected $attributes = [
        'type' => 'news'
    ];

    protected $fillable = ['title', 'slug', 'meta_keywords', 'translation_language_code',
        'meta_description', 'content', 'published', 'published_at', 'private', 'internal', 'type', 'author_id', 'template', 'featured_image_link'];


}