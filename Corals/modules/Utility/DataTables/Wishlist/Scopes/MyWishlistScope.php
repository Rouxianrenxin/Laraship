<?php

namespace Corals\Modules\Utility\DataTables\Wishlist\Scopes;


use Yajra\DataTables\Contracts\DataTableScope;

class MyWishlistScope implements DataTableScope
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Apply a query scope.
     *
     * @param \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder $query
     * @return mixed
     */
    public function apply($query)
    {
        $query->where('user_id', $this->user->id);
    }
}