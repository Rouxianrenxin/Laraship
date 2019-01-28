<?php

namespace Corals\Modules\CMS\Models;

use Illuminate\Database\Eloquent\Builder;
use Corals\Modules\Utility\Traits\Tag\HasTags;
use Cviebrock\EloquentSluggable\Sluggable;

class Faq extends Content
{
    use HasTags, Sluggable;

    public function getModuleName()
    {
        return 'CMS';
    }
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'faq');
        });
    }

    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'cms.models.faq';

    protected $table = 'posts';

    protected $attributes = [
        'type' => 'faq'
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true
            ]
        ];
    }

    protected $fillable = ['title', 'slug', 'tags', 'translation_language_code', 'content', 'published', 'published_at', 'type', 'author_id'];


}
