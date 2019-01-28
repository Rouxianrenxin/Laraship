<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 12/4/2017
 * Time: 10:49 AM
 */

namespace Corals\Foundation\Traits;


trait HashTrait
{
    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        $decoded_value = hashids_decode($value);

        return $this->where($this->getRouteKeyName(), $decoded_value)->first();
    }

    public function getHashedIdAttribute()
    {
        return hashids_encode($this->{$this->getRouteKeyName()});
    }

    public static function findByHash($value)
    {
        $decoded_value = hashids_decode($value);

        return self::find($decoded_value);
    }
}