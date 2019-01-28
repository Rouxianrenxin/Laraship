<?php

namespace Corals\Menu\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\Foundation\Traits\Cache\Cachable;
use Corals\Foundation\Transformers\PresentableTrait;
use Corals\Traits\Node\SimpleNode;

class Menu extends BaseModel
{
    use PresentableTrait, SimpleNode, Cachable;

    protected $orderField = 'order';

    protected $guarded = ['id', 'root'];

    protected $casts = [
        'roles' => 'array'
    ];
    public $config = 'menu.models.menu';

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->whereStatus('active');
    }

    public function setIconAttribute($value)
    {
        if ($value) {
            $this->attributes['icon'] = 'fa ' . $value;
        } else {
            $this->attributes['icon'] = null;
        }
    }

    public function getUserCanAccessAttribute($value)
    {
        if (user()) {
            $userRoles = user()->roles->pluck('id');
        } else {
            return true;
        }

        $roles = collect($this->roles);

        if ($roles->isEmpty()) {
            return true;
        }

        $intersection = $roles->intersect($userRoles);

        return $intersection->count();
    }

    public function getUrlAttribute()
    {
        return $this->attributes['url'] ?? '#';
    }
}