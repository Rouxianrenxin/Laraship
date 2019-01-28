<?php

namespace Corals\Modules\Utility\DataTables\Wishlist\Scopes;


use Yajra\DataTables\Contracts\DataTableScope;

class WishlistTypeScope implements DataTableScope
{
    protected $wishlistableClass;

    public function __construct($wishlistableClass)
    {
        $this->wishlistableClass = $wishlistableClass;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        $query->where('wishlistable_type', $this->wishlistableClass);
    }
}