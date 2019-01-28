<?php

namespace Corals\Modules\CMS\Models;

use Carbon\Carbon;
use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\User\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class Content extends BaseModel implements HasMedia
{
    use PresentableTrait, LogsActivity, HasMediaTrait;

    protected $table = 'posts';

    protected static $logAttributes = ['title'];

    protected $casts = [
        'published' => 'boolean',
        'private' => 'boolean',
        'internal' => 'boolean',
        'published_at' => 'date',
        'extras' => 'array'
    ];


    protected $contentTypeMapping = [
        'page' => Page::class,
        'post' => Post::class,
        'news' => News::class,
        'faq' => Faq::class,
    ];

    public function getFeaturedImageAttribute()
    {
        $media = $this->getFirstMedia('featured-image');

        if ($media) {
            return $media->getUrl();
        } elseif (isset($this->attributes['featured_image_link']) && $this->attributes['featured_image_link']) {
            return url($this->attributes['featured_image_link']);
        }

        return null;
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }

    public function setPublishedAttribute($value)
    {
        if ($value) {
            $this->attributes['published'] = $value;
            $this->attributes['published_at'] = Carbon::now();
        } else {
            $this->attributes['published'] = $value;
            $this->attributes['published_at'] = null;
        }
    }

    /**
     * @return string
     * @throws FatalThrowableError
     * @throws \Exception
     */
    public function getRenderedAttribute()
    {
        $__data['__env'] = app(\Illuminate\View\Factory::class);
        extract($__data);
        $obLevel = ob_get_level();
        ob_start();
        $content = $this->attributes['content'];

        $content = str_ireplace(array('<?php', '@php', '<?', '@endphp', '?>'), array('&lt;?php', '&lt;?PHP', '&lt;?', '&gt;?php', '?&gt;'), $content);

        $php = \Blade::compileString($content);
        try {
            eval('?' . '>' . $php);
        } catch (\Exception $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw new FatalThrowableError($e);
        }
        return ob_get_clean();
    }

    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

    public function scopePrivate($query)
    {
        return $query->where('private', 1);
    }

    public function scopeInternal($query, $state = true)
    {
        return $query->where('internal', $state);
    }

    public function scopePublic($query)
    {
        return $query->where('private', 0);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function page()
    {
        return $this->hasOne(Page::class, 'id');
    }

    public function post()
    {
        return $this->hasOne(Post::class, 'id');
    }

    public function faq()
    {
        return $this->hasOne(Faq::class, 'id');
    }
    /**
     * Get all of the users that are accessable this post.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'postable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post', 'post_id');
    }

    public function activeCategories()
    {
        $not_available_categories = \CMS::getNotAvailableCategories();
        return $this->belongsToMany(Category::class, 'category_post', 'post_id')->where('status', 'active')->whereNotIn('id', $not_available_categories);


    }


    public function toContentType()
    {
        $class = $this->contentTypeMapping[$this->type];

        if (class_exists($class)) {
            return (new $class())
                ->newInstance([], true)
                ->setRawAttributes($this->getAttributes());
        }

        throw new \Exception('Invalid Post Type.');
    }
}
