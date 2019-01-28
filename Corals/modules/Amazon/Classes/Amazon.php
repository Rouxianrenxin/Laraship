<?php

namespace Corals\Modules\Amazon\Classes;

use Corals\Modules\Amazon\Models\AmazonCategory;

class Amazon
{
    /**
     * Amazon constructor.
     */
    function __construct()
    {
    }

    /**
     * @return array|mixed
     */
    public function getAmazonCategories()
    {
        return AmazonCategory::active()->pluck('name', 'id')->toArray();

    }
}