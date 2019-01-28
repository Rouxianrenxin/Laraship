<?php

namespace Corals\Foundation\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\Pivot;

use Illuminate\Database\Eloquent\Builder;
use Corals\Foundation\Models\Relations\hasManyDeep;

use Illuminate\Database\Eloquent\Model;



trait BaseRelations
{

    /**
     * Define a has-many-deep relationship.
     *
     * @param  string $related
     * @param  array $through
     * @param  array $foreignKeys
     * @param  array $localKeys
     * @return hasManyDeep
     */
    public function hasManyDeep($related, array $through, array $foreignKeys = [], array $localKeys = [])
    {
        $relatedInstance = $this->newRelatedInstance($related);
        $throughParents = array_map(function ($class) {
            return Str::contains($class, '\\') ? new $class : (new Pivot)->setTable($class);
        }, $through);
        foreach (array_merge([$this], $throughParents) as $i => $instance) {
            if (!isset($foreignKeys[$i])) {
                if ($instance instanceof Pivot) {
                    $foreignKeys[$i] = ($throughParents[$i] ?? $relatedInstance)->getKeyName();
                } else {
                    $foreignKeys[$i] = $instance->getForeignKey();
                }
            }
            if (!isset($localKeys[$i])) {
                if ($instance instanceof Pivot) {
                    $localKeys[$i] = ($throughParents[$i] ?? $relatedInstance)->getForeignKey();
                } else {
                    $localKeys[$i] = $instance->getKeyName();
                }
            }
        }
        return $this->newhasManyDeep($relatedInstance->newQuery(), $this, $throughParents, $foreignKeys, $localKeys);
    }

    /**
     * Instantiate a new hasManyDeep relationship.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \Illuminate\Database\Eloquent\Model $farParent
     * @param  \Illuminate\Database\Eloquent\Model[] $throughParents
     * @param  array $foreignKeys
     * @param  array $localKeys
     * @return hasManyDeep
     */
    protected function newhasManyDeep(Builder $query, Model $farParent, array $throughParents, array $foreignKeys, array $localKeys)
    {
        return new hasManyDeep($query, $farParent, $throughParents, $foreignKeys, $localKeys);
    }


}
