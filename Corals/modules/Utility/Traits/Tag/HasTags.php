<?php

namespace Corals\Modules\Utility\Traits\Tag;

use Corals\Modules\Utility\Models\Tag\Tag;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    protected $queuedTags = [];

    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    public static function bootHasTags()
    {
        static::created(function (Model $taggableModel) {
            $taggableModel->attachTags($taggableModel->queuedTags);

            $taggableModel->queuedTags = [];
        });

        static::deleted(function (Model $deletedModel) {
            $tags = $deletedModel->tags()->get();

            $deletedModel->detachTags($tags);
        });
    }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'utility_taggables');
    }

    public function activeTags()
    {
        return $this->tags()->where('utility_tags.status', 'active');
    }

    /**
     * @param string|array|\ArrayAccess|Tag $tags
     */
    public function setTagsAttribute($tags)
    {
        if (!$this->exists) {
            $this->queuedTags = $tags;

            return;
        }

        $this->attachTags($tags);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array|\ArrayAccess|Tag $tags
     * @param string $module
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAllTags(Builder $query, $tags, string $module = null): Builder
    {
        $tags = static::convertToTags($tags, $module);

        collect($tags)->each(function ($tag) use ($query) {
            $query->whereHas('tags', function (Builder $query) use ($tag) {
                return $query->where('id', $tag ? $tag->id : 0);
            });
        });

        return $query;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array|\ArrayAccess|Tag $tags
     * @param string $module
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithAnyTags(Builder $query, $tags, string $module = null): Builder
    {
        $tags = static::convertToTags($tags, $module);

        return $query->whereHas('tags', function (Builder $query) use ($tags) {
            $tagIds = collect($tags)->pluck('id');

            $query->whereIn('id', $tagIds);
        });
    }

    public function tagsWithModule(string $module = null): Collection
    {
        $tags = $this->tags()->get();

        return $tags->filter(function (Tag $tag) use ($module) {
            return $tag->module === $module;
        });
    }

    /**
     * @param array|\ArrayAccess|Tag $tags
     *
     * @return $this
     */
    public function attachTags($tags)
    {
        $className = static::getTagClassName();

        $existingTags = array_filter($tags, function ($tag) {
            return is_numeric($tag);
        });

        $newTags = array_filter($tags, function ($tag) {
            return !is_numeric($tag);
        });

        $tags = $className::find($existingTags);

        foreach ($newTags as $newTag) {
            $tags = $tags->push($className::create(['name' => $newTag, 'module' => $this->getModuleName()]));
        }

        $this->tags()->sync($tags->pluck('id')->toArray());

        return $this;
    }

    public function getModuleName()
    {
        return null;
    }

    /**
     * @param string|Tag $tag
     *
     * @return $this
     */
    public function attachTag($tag)
    {
        return $this->attachTags([$tag]);
    }

    /**
     * @param array|\ArrayAccess $tags
     *
     * @return $this
     */
    public function detachTags($tags)
    {
        $tags = static::convertToTags($tags);

        collect($tags)
            ->filter()
            ->each(function (Tag $tag) {
                $this->tags()->detach($tag);
            });

        return $this;
    }

    /**
     * @param string|Tag $tag
     *
     * @return $this
     */
    public function detachTag($tag)
    {
        return $this->detachTags([$tag]);
    }

    /**
     * @param array|\ArrayAccess $tags
     *
     * @return $this
     */
    public function syncTags($tags)
    {
        $className = static::getTagClassName();

        $tags = collect($className::findOrCreate($tags));

        $this->tags()->sync($tags->pluck('id')->toArray());

        return $this;
    }

    /**
     * @param array|\ArrayAccess $tags
     * @param string|null $module
     *
     * @return $this
     */
    public function syncTagsWithModule($tags, string $module = null)
    {
        $className = static::getTagClassName();

        $tags = collect($className::findOrCreate($tags, $module));

        $this->syncTagIds($tags->pluck('id')->toArray(), $module);

        return $this;
    }

    protected static function convertToTags($values, $module = null, $locale = null)
    {
        return collect($values)->map(function ($value) use ($module, $locale) {
            if ($value instanceof Tag) {
                if (isset($module) && $value->module != $module) {
                    throw new InvalidArgumentException("Module was set to {$module} but tag is of module {$value->module}");
                }

                return $value;
            }

            $className = static::getTagClassName();

            return $className::findFromString($value, $module, $locale);
        });
    }

    /**
     * Use in place of eloquent's sync() method so that the tag module may be optionally specified.
     *
     * @param $ids
     * @param string|null $module
     * @param bool $detaching
     */
    protected function syncTagIds($ids, string $module = null, $detaching = true)
    {
        $isUpdated = false;

        // Get a list of tag_ids for all current tags
        $current = $this->tags()
            ->newPivotStatement()
            ->where('taggable_id', $this->getKey())
            ->when($module !== null, function ($query) use ($module) {
                $tagModel = $this->tags()->getRelated();

                return $query->join(
                    $tagModel->getTable(),
                    'utility_taggables.tag_id',
                    '=',
                    $tagModel->getTable() . '.' . $tagModel->getKeyName()
                )
                    ->where('tags.module', $module);
            })
            ->pluck('tag_id')
            ->all();

        // Compare to the list of ids given to find the tags to remove
        $detach = array_diff($current, $ids);
        if ($detaching && count($detach) > 0) {
            $this->tags()->detach($detach);
            $isUpdated = true;
        }

        // Attach any new ids
        $attach = array_diff($ids, $current);
        if (count($attach) > 0) {
            collect($attach)->each(function ($id) {
                $this->tags()->attach($id, []);
            });
            $isUpdated = true;
        }

        // Once we have finished attaching or detaching the records, we will see if we
        // have done any attaching or detaching, and if we have we will touch these
        // relationships if they are configured to touch on any database updates.
        if ($isUpdated) {
            $this->tags()->touchIfTouching();
        }
    }
}