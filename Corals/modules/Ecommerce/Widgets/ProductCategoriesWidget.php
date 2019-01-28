<?php

namespace Corals\Modules\Ecommerce\Widgets;

use \Corals\Modules\Ecommerce\Models\Category;

class ProductCategoriesWidget
{

    function __construct()
    {
    }

    function run($args)
    {

        $categories = Category::count();
        return ' <!-- small box -->
            <div class="card">
                <div class="small-box bg-red card-body ">
                    <div class="inner">
                        <h3>' . $categories . '</h3>
                        <p>' . trans('Ecommerce::labels.widget.product_categories') . '</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-folder-open fa-fw"></i>
                    </div>
                    <a href="' . url('e-commerce/categories') . '" class="small-box-footer">
                        ' . trans('Corals::labels.more_info') . '
                    </a>
                </div>
            </div>';
    }

}